<?php

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Models\User;
use Orchid\Screen\TD;
use Orchid\Tests\App\Components\SimpleShowValue;
use Orchid\Tests\App\Components\SimpleShowValueWithArguments;
use Orchid\Tests\TestUnitCase;

class TDComponentAsValueTest extends TestUnitCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->make();
    }

    public function test_td_simple_component(): void
    {
        $view = TD::make('email')
            ->asComponent(SimpleShowValue::class)
            ->buildTd($this->user);

        $this->assertStringContainsString($this->user->email, $view);
    }

    public function test_td_without_argument_component()
    {
        $view = TD::make('email')
            ->asComponent(SimpleShowValueWithArguments::class)
            ->buildTd($this->user);

        $this->assertStringContainsString("Hello {$this->user->email} from Alexandr", $view);
        $this->assertStringContainsString(app()->version(), $view);
    }

    public function test_td_argument_component(): void
    {
        $view = TD::make('email')
            ->asComponent(SimpleShowValueWithArguments::class, [
                'from' => 'Sasha',
            ])
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    public function test_td_argument_view(): void
    {
        $view = TD::make('email')
            ->asComponent(SimpleShowValueWithArguments::class, [
                'from' => 'Sasha',
            ])
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    public function test_td_argument_view_using_component(): void
    {
        $view = TD::make('email')
            ->usingComponent(SimpleShowValueWithArguments::class, from: 'Sasha')
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    public function test_td_argument_view_with_closure_argument(): void
    {
        $view = TD::make('email')
            ->asComponent(SimpleShowValueWithArguments::class, [
                'from' => fn () => 'Sasha',
            ])
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    public function test_td_anonymous_component_with_closure_arguments(): void
    {
        $view = TD::make('email')
            ->asComponent('exemplar::simple-anonymous-component', [
                'property1' => fn ($email) => $email.'3333',
                'property2' => fn ($email) => $email.'4444',
            ])
            ->buildTd($this->user);

        $this->assertStringContainsString($this->user->email.'3333', $view);
        $this->assertStringContainsString($this->user->email.'4444', $view);
    }

    protected function checkedArgument(View $view)
    {
        $this->assertStringContainsString("Hello {$this->user->email} from Sasha", $view);
        $this->assertStringContainsString(app()->version(), $view);
    }
}
