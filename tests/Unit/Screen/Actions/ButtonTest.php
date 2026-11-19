<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Orchid;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class ButtonTest.
 */
class ButtonTest extends TestFieldsUnitCase
{
    public function testButtonInstance(): void
    {
        $button = Button::make('About')
            ->method('test');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test',
            $view
        );
    }

    public function testButtonParams(): void
    {
        $button = Button::make('About')
            ->method('test')
            ->parameters([
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'name="_parameters" value="{&quot;name&quot;:&quot;Alexandr&quot;}',
            $view
        );
    }

    public function testButtonWithNullParameters(): void
    {
        $button = Button::make('About')
            ->method('test', [
                'id'   => null,
                'name' => 'Alexandr',
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'name="_parameters" value="{&quot;name&quot;:&quot;Alexandr&quot;}',
            $view
        );
    }

    public function testButtonWithZeroParameters(): void
    {
        $button = Button::make('About')
            ->method('test', [
                'value' => 0,
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'name="_parameters" value="{&quot;value&quot;:0}',
            $view
        );
    }

    public function testButtonTitle(): void
    {
        $button = Button::make('About')
            ->method('test')
            ->title('Submit form');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'Submit form',
            $view
        );
    }

    public function testButtonDisableTurbolinks(): void
    {
        $button = Button::make('About')
            ->method('test')
            ->rawClick();

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'data-turbo="false"',
            $view
        );
    }

    public function testButtonEnabledTurbolinks(): void
    {
        $button = Button::make('About')
            ->method('test')
            ->rawClick(true);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'data-turbo="true"',
            $view
        );
    }

    public function testButtonForCustomAction(): void
    {
        $buttonForRoute = Button::make('About')
            ->action(route('orchid.index'));

        $view = self::renderField($buttonForRoute);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/dashboard"',
            $view
        );

        $buttonForLink = Button::make('Example')
            ->action('http://example.com');

        $view = self::renderField($buttonForLink);

        $this->assertStringContainsString(
            'formaction="http://example.com"',
            $view
        );
    }

    public function testButtonWhenDisable(): void
    {
        $button = Button::make('About')
            ->method('test')
            ->when(true, function (Button $button) {
                $button->disabled(true);
            });

        $view = self::renderField($button);

        $this->assertStringContainsString('disabled', $view);

        $button = Button::make('About')
            ->method('test')
            ->when(false, function (Button $button) {
                $button->disabled(true);
            });

        $view = self::renderField($button);

        $this->assertStringNotContainsString('disabled', $view);
    }

    public function testButtonMethodParameters(): void
    {
        $button = Button::make('About')
            ->method('test', [
                'id' => 1,
            ]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'name="_parameters" value="{&quot;id&quot;:1}',
            $view
        );
    }

    public function testButtonMethodParametersOverwrite(): void
    {
        $button = Button::make('About')
            ->parameters([
                'id' => 1,
            ])
            ->method('test');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'name="_parameters" value="{&quot;id&quot;:1}',
            $view
        );
    }

    public function testButtonActionMovesQueryStringFromPreviousUrlBehindTheMethod(): void
    {
        // A partial request (e.g. a table rendered inside an async modal on
        // a paginated screen) has its "previous URL" carry the page's own
        // query string. That must not be spliced in front of the method
        // name (it would break routing), but it must still reach the final
        // action so things like active filters keep applying.
        request()->headers->set('referer', 'http://127.0.0.1:8001/test?page=2');

        Orchid::setCurrentScreen(new class extends Screen
        {
            public function layout(): iterable
            {
                return [];
            }
        }, true);

        $button = Button::make('About')
            ->method('test');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test/test?page=2"',
            $view
        );
    }

    public function testButtonActionPreservesThePreviousQueryString(): void
    {
        Orchid::setCurrentScreen(new class extends Screen
        {
            public function layout(): iterable
            {
                return [];
            }
        }, true);

        foreach (['filter%5Bstatus%5D=active&search=Alex%20Smith&page=2', 'next=/users/', 'search=what?', '0'] as $query) {
            request()->headers->set('referer', 'http://127.0.0.1:8001/test?'.$query);

            $view = self::renderField(Button::make('Export')->method('export'));

            $this->assertStringContainsString(
                'formaction="'.e('http://127.0.0.1:8001/test/export?'.$query).'"',
                $view
            );
        }
    }

    public function testButtonMethodParametersStaySeparateFromPreviousQueryString(): void
    {
        request()->headers->set('referer', 'http://127.0.0.1:8001/test?id=1');

        Orchid::setCurrentScreen(new class extends Screen
        {
            public function layout(): iterable
            {
                return [];
            }
        }, true);

        $button = Button::make('About')
            ->method('test', ['id' => 2]);

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'formaction="http://127.0.0.1:8001/test/test?id=1"',
            $view
        );
        $this->assertStringContainsString('name="_parameters" value="{&quot;id&quot;:2}"', $view);
    }

    public function testButtonMethodParametersAcceptsEloquentModel(): void
    {
        $user = User::factory()->create();

        $button = Button::make('About')
            ->parameters([
                'user' => $user,
            ])
            ->method('test');

        $view = self::renderField($button);

        $this->assertStringContainsString(
            'value="'.e(json_encode(['user' => $user->getKey()])).'"',
            $view
        );
    }
}
