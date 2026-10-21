<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Builder;
use Orchid\Screen\Fields\BlockEditor;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\KeyValue;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Repeater;
use Orchid\Screen\Fields\TextArea;
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
        $this->assertMatchesRegularExpression('/<fieldset[^>]* disabled\b/', $readonlyHtml);
        $this->assertMatchesRegularExpression('/<fieldset[^>]* disabled\b/', $disabledHtml);
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

    public function testNullSubmissionFromMiddlewareKeepsEveryRowDeleted(): void
    {
        $this->registerValidationRoutes();
        $this->from('/repeater')->post('/repeater', ['team' => ['members' => '']])
            ->assertRedirect('/repeater')
            ->assertSessionHasErrors('required');

        $this->get('/repeater')->assertOk()
            ->assertSee('data-repeater-index="0"', false)
            ->assertDontSee('value="Stored"', false);
    }

    public function testRejectedOldRowsRenderWithoutThrowingOrResurrectingStoredRows(): void
    {
        $this->registerValidationRoutes();
        foreach (['invalid', [2 => 'invalid', 7 => ['profile' => ['name' => 'Good']]]] as $rows) {
            $this->from('/repeater')->post('/repeater', ['team' => ['members' => $rows]])
                ->assertRedirect('/repeater');

            $response = $this->get('/repeater')->assertOk()->assertDontSee('value="Stored"', false);
            if (is_array($rows)) {
                $response->assertSee('name="team[members][7][profile][name]"', false)
                    ->assertSee('value="Good"', false);
            } else {
                $response->assertSee('data-repeater-index="0"', false);
            }
        }
    }

    public function testSparseReorderedOldRowsKeepTheirValuesAndValidationFeedback(): void
    {
        $this->registerValidationRoutes();
        $this->from('/repeater')->post('/repeater', ['team' => ['members' => [
            2 => ['profile' => ['name' => 'Second']],
            1 => ['profile' => ['name' => 'First']],
            5 => ['profile' => ['name' => '']],
        ]]])->assertRedirect('/repeater')->assertSessionHasErrors('team.members.5.profile.name');

        $this->assertSame('Second', session()->getOldInput('team.members.2.profile.name'));
        $html = $this->get('/repeater')->assertOk()->getContent();
        $this->assertMatchesRegularExpression('/name="team\[members\]\[2\]\[profile\]\[name\]"[^>]*value="Second"/', $html);
        $this->assertMatchesRegularExpression('/name="team\[members\]\[1\]\[profile\]\[name\]"[^>]*value="First"/', $html);
        $this->assertStringContainsString('invalid-feedback', $html);
        $this->assertStringContainsString('team.members.5.profile.name', $html);
    }

    public function testExplicitNullClearsChildDefaultsWhileAbsentKeysUseDefaults(): void
    {
        request()->setLaravelSession(app(Store::class));
        session()->flashInput(['team' => ['members' => [1 => [
            'profile'  => ['name' => null],
            'children' => null,
            'metadata' => null,
            'body'     => null,
        ], 2 => []]]]);
        $oldInput = session()->getOldInput();
        $html = (new Builder([Repeater::make('team.members')->fields([
            Input::make('profile.name')->value('Default name'),
            Repeater::make('children')->fields([Input::make('name')])->value([['name' => 'Default child']]),
            KeyValue::make('metadata')->value(['default key' => 'Default metadata']),
            BlockEditor::make('body')->value(['blocks' => [['type' => 'paragraph', 'data' => ['text' => 'Default body']]]]),
        ])]))->generateForm();
        $this->assertSame($oldInput, session()->getOldInput());
        $document = new \DOMDocument;
        @$document->loadHTML($html);
        $xpath = new \DOMXPath($document);
        $firstRow = $xpath->query('//*[@name="team[members][1][profile][name]"]')->item(0);
        $this->assertNotNull($firstRow);
        $this->assertSame('', $firstRow->getAttribute('value'));
        $this->assertStringContainsString('name="team[members][2][profile][name]" value="Default name"', $html);
        $this->assertStringNotContainsString('name="team[members][1][children][0][name]"', $html);
        $this->assertSame('Default child', $xpath->query('//*[@name="team[members][2][children][0][name]"]')->item(0)?->getAttribute('value'));
        $this->assertStringNotContainsString('name="team[members][1][metadata][0][key]" value="default key"', $html);
        $this->assertSame('Default metadata', $xpath->query('//*[@data-key-value-cell="value" and @name="team[members][2][metadata][0][value]"]')->item(0)?->getAttribute('value'));
        $this->assertSame('{"blocks":[]}', $xpath->query('//*[@name="team[members][1][body]"]')->item(0)?->textContent);
        $this->assertStringContainsString('Default body', $xpath->query('//*[@name="team[members][2][body]"]')->item(0)?->textContent ?? '');
    }

    public function testInvalidTextChildValuesRedisplayAfterRealValidationFailure(): void
    {
        Route::middleware(['web', ConvertEmptyStringsToNull::class])->group(function () {
            Route::post('/repeater-text-fields', function (Request $request) {
                $request->validate([
                    'members.*.name' => ['string'],
                    'members.*.bio'  => ['string'],
                    'members.*.body' => ['string'],
                ]);
            });
            Route::get('/repeater-text-fields', fn () => (new Builder([
                Repeater::make('members')->fields([
                    Input::make('name')->value('Stored name'),
                    TextArea::make('bio')->value('Stored bio'),
                    Quill::make('body')->value('<p>Stored body</p>'),
                    Input::make('kept'),
                ]),
            ]))->generateForm());
        });
        $this->from('/repeater-text-fields')->post('/repeater-text-fields', [
            'members' => [['name' => ['invalid'], 'bio' => ['invalid'], 'body' => ['invalid'], 'kept' => 'Valid sibling']],
        ])->assertRedirect('/repeater-text-fields')->assertSessionHasErrors([
            'members.0.name', 'members.0.bio', 'members.0.body',
        ]);
        $response = $this->get('/repeater-text-fields')->assertOk();
        $document = new \DOMDocument;
        @$document->loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $this->assertSame('', $xpath->query('//input[@name="members[0][name]"]')->item(0)->getAttribute('value'));
        $this->assertSame('', $xpath->query('//textarea[@name="members[0][bio]"]')->item(0)->textContent);
        $this->assertSame('', $xpath->query('//textarea[@name="members[0][body]"]')->item(0)->textContent);
        $this->assertSame('Valid sibling', $xpath->query('//input[@name="members[0][kept]"]')->item(0)->getAttribute('value'));
    }

    private function registerValidationRoutes(): void
    {
        Route::middleware(['web', ConvertEmptyStringsToNull::class])->group(function () {
            Route::post('/repeater', function (Request $request) {
                $request->validate([
                    'team.members'                => ['nullable', 'array'],
                    'team.members.*'              => ['array'],
                    'team.members.*.profile.name' => ['required', 'string'],
                    'required'                    => ['required'],
                ]);
            });
            Route::get('/repeater', fn () => (new Builder([
                Repeater::make('team.members')->fields([Input::make('profile.name')->value('Default')]),
            ], new Repository(['team' => ['members' => [['profile' => ['name' => 'Stored']]]]])))->generateForm());
        });
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
