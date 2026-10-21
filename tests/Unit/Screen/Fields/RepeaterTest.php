<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Session\Store;
use Orchid\Screen\Builder;
use Orchid\Screen\Fields\BlockEditor;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\KeyValue;
use Orchid\Screen\Fields\Repeater;
use Orchid\Screen\Repository;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class RepeaterTest extends TestFieldsUnitCase
{
    public function testNestedCollectionsHaveIndependentPlaceholdersAndHydratedValues(): void
    {
        $outer = '__repeater_'.hash('sha256', 'members').'__';
        $nested = '__repeater_'.hash('sha256', 'members['.$outer.'][children]').'__';
        $html = Repeater::make('members')->fields([
            Repeater::make('children')->fields([Input::make('name')]),
            KeyValue::make('metadata'),
        ])->value([[
            'children' => [['name' => 'Child']],
            'metadata' => [['key' => 'Color', 'value' => 'Blue']],
        ]])->render()->render();

        $this->assertStringContainsString('data-repeater-placeholder="'.$outer.'"', $html);
        $this->assertStringContainsString('data-repeater-placeholder="'.$nested.'"', $html);
        $this->assertStringContainsString('name="members['.$outer.'][children]['.$nested.'][name]"', $html);
        $this->assertStringContainsString('name="members['.$outer.'][metadata][{index}][key]"', $html);
        $this->assertStringContainsString('name="members[0][children][0][name]"', $html);
        $this->assertStringContainsString('value="Child"', $html);
        $this->assertStringContainsString('value="Blue"', $html);
    }

    public function testNestedCollectionsCannotBeSilentlyDiscardedWhenDuplicating(): void
    {
        foreach ([Repeater::make('children'), KeyValue::make('metadata')] as $child) {
            try {
                Repeater::make('members')->fields([$child])->cloneableRows()->render();
                $this->fail('Nested collection duplication must be rejected.');
            } catch (\InvalidArgumentException $exception) {
                $this->assertSame('Repeater rows containing Repeater or KeyValue fields cannot be duplicated.', $exception->getMessage());
            }
        }
    }

    public function testLockedRowsPropagateTheirStateToCustomEditorsWithoutMutatingSources(): void
    {
        $child = BlockEditor::make('body');
        foreach (['readonly', 'disabled'] as $state) {
            $html = Repeater::make('members')->fields([$child])->emptyRows(1)->{$state}()->render()->render();
            $this->assertStringContainsString('data-block-editor-'.$state."-value='true'", $html);
            $this->assertFalse((bool) $child->get($state));
        }
    }

    public function testBuilderHydratesSparseRowsAndNestedChildren(): void
    {
        $field = Repeater::make('team.members')->fields([
            Input::make('profile.name')->value('Default'),
        ]);
        $html = (new Builder([$field], new Repository(['team' => ['members' => [
            4 => ['profile' => ['name' => 'Alex']],
            8 => [],
        ]]])))->generateForm();

        $this->assertStringContainsString('name="team[members][0][profile][name]"', $html);
        $this->assertStringContainsString('value="Alex"', $html);
        $this->assertStringContainsString('name="team[members][1][profile][name]"', $html);
        $this->assertStringContainsString('value="Default"', $html);
        $this->assertStringContainsString('data-repeater-index="2"', $html);
    }

    public function testOldInputReplacesRowsAndPreservesNestedValues(): void
    {
        request()->setLaravelSession(app(Store::class));
        session()->flashInput(['team' => ['members' => [['profile' => ['name' => 'Submitted']]]]]);
        $field = Repeater::make('team.members')->fields([Input::make('profile.name')])
            ->value([['profile' => ['name' => 'Original']], []]);
        $html = (new Builder([$field]))->generateForm();

        $this->assertStringContainsString('value="Submitted"', $html);
        $this->assertStringNotContainsString('value="Original"', $html);
        $this->assertStringContainsString('data-repeater-index="1"', $html);
    }

    public function testDeletingEveryRowOverridesStoredRowsOnValidationFailure(): void
    {
        request()->setLaravelSession(app(Store::class));
        session()->flashInput(['members' => '']);
        $field = Repeater::make('members')->fields([Input::make('name')]);
        $html = (new Builder([$field], new Repository(['members' => [['name' => 'Stored']]])))->generateForm();

        $this->assertStringContainsString('type="hidden" name="members" value=""', $html);
        $this->assertStringContainsString('data-repeater-index="0"', $html);
        $this->assertStringNotContainsString('value="Stored"', $html);
    }

    public function testDifferentRepeatersDoNotShareChildIds(): void
    {
        $first = Repeater::make('members')->fields([Input::make('profile.name'), Input::make('profile-name')])->emptyRows(1);
        $second = Repeater::make('contacts')->fields([Input::make('name')])->emptyRows(1);
        $html = (new Builder([$first, $second]))->generateForm();
        preg_match_all('/\bid="([^"]+)"/', $html, $matches);

        $this->assertCount(count($matches[1]), array_unique($matches[1]));
    }

    public function testClosureValueAndEmptySubmissionNormalizeToRows(): void
    {
        $field = Repeater::make('members')->fields([Input::make('name')])
            ->value(fn () => [5 => ['name' => 'Deferred']]);
        $html = $field->render()->render();

        $this->assertStringContainsString('name="members[0][name]"', $html);
        $this->assertStringContainsString('value="Deferred"', $html);
        $this->assertSame([], Repeater::make('members')->value('')->get('value'));
    }

    public function testLockedFieldsDisableChildControlsAndDisabledFieldsOmitEmptySubmission(): void
    {
        $readonly = Repeater::make('members')->fields([Input::make('name')])->emptyRows(1)->readonly();
        $readonlyHtml = $readonly->render()->render();
        $disabled = Repeater::make('contacts')->fields([Input::make('name')])->emptyRows(1)->disabled();
        $disabledHtml = $disabled->render()->render();

        $this->assertStringContainsString('data-repeater-readonly="true"', $readonlyHtml);
        $this->assertStringContainsString('<fieldset class="border-0 p-0 m-0" disabled>', $readonlyHtml);
        $this->assertStringContainsString('<fieldset class="border-0 p-0 m-0" disabled>', $disabledHtml);
        $this->assertStringNotContainsString('data-repeater-target="empty"', $disabledHtml);
    }

    public function testHiddenChildrenDoNotRenderOrMutateSources(): void
    {
        $source = Input::make('secret')->canSee(false);
        $html = Repeater::make('members')->fields([$source])->value([['secret' => 'Hidden']])->render()->render();

        $this->assertStringNotContainsString('name="members[0][secret]"', $html);
        $this->assertStringNotContainsString('value="Hidden"', $html);
        $this->assertSame('secret', $source->get('name'));
        $this->assertNull($source->get('prefix'));
    }

    public function testMalformedRowsAreRejectedInsteadOfDiscarded(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Repeater::make('members')->value([['name' => 'Alex'], 'lost row']);
    }

    public function testNegativeMaximumIsRejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Repeater::make('members')->maxRows(-1);
    }

    public function testFieldsValue(): void
    {
        $repeater = Repeater::make('members')
            ->fields([
                Input::make('name'),
                Input::make('role'),
            ])
            ->value([
                [
                    'name' => 'Alex',
                    'role' => 'Owner',
                ],
                [
                    'name' => 'Sam',
                    'role' => 'Member',
                ],
            ]);

        $view = self::minifyRenderField($repeater);

        $this->assertStringContainsString('name="members[0][name]"', $view);
        $this->assertStringContainsString('value="Alex"', $view);
        $this->assertStringContainsString('name="members[1][role]"', $view);
        $this->assertStringContainsString('value="Member"', $view);
    }

    public function testEmptyRows(): void
    {
        $repeater = Repeater::make('members')
            ->fields([
                Input::make('name'),
            ])
            ->emptyRows(2);

        $view = self::minifyRenderField($repeater);

        $this->assertStringContainsString('name="members[0][name]"', $view);
        $this->assertStringContainsString('name="members[1][name]"', $view);
    }

    public function testActions(): void
    {
        $repeater = Repeater::make('members')
            ->fields([
                Input::make('name'),
            ])
            ->cloneableRows()
            ->reorderableRows()
            ->maxRows(3);

        $view = self::minifyRenderField($repeater);

        $this->assertStringContainsString('data-repeater-rows="3"', $view);
        $this->assertStringContainsString('data-action="repeater#cloneRow"', $view);
        $this->assertStringContainsString('data-action="repeater#moveUp"', $view);
        $this->assertStringNotContainsString('data-action="repeater#toggleRow"', $view);
        $this->assertStringNotContainsString('Item 1', $view);
    }

    public function testCustomIdPrefix(): void
    {
        $repeater = Repeater::make('members')
            ->fields([
                Input::make('name'),
            ])
            ->idPrefix('custom-prefix')
            ->value([
                [
                    'name' => 'Alex',
                ],
            ]);

        $view = self::minifyRenderField($repeater);

        $this->assertStringContainsString('id="custom-prefix-0-0-name"', $view);
    }
}
