<?php

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Models\User;
use Orchid\Screen\TD;
use Orchid\Tests\App\Components\Hello;
use Orchid\Tests\App\Components\UserTD;
use Orchid\Tests\App\Components\UserTDArguments;
use Orchid\Tests\App\Components\UserTDView;
use Orchid\Tests\TestUnitCase;

class TDComponentTest extends TestUnitCase
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

    public function testTdSimpleComponent(): void
    {
        $view = TD::make()
            ->component(UserTD::class)
            ->buildTd($this->user);

        $this->assertStringContainsString($this->user->email, $view);
    }

    public function testTdArgumentComponent(): void
    {
        $view = TD::make()
            ->component(UserTDArguments::class, [
                'from' => 'Sasha',
            ])
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    public function testTdArgumentView(): void
    {
        $view = TD::make()
            ->component(UserTDView::class, [
                'from' => 'Sasha',
            ])
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    public function testTdComponentWithMixedArguments(): void
    {
        $view = TD::make()
            ->component(Hello::class, [
                'application' => $this->app,
                'name'        => fn (User $user) => $user->name,
            ])
            ->buildTd($this->user);

        $this->assertStringContainsString($this->user->name, $view);
        $this->assertStringContainsString($this->app->version(), $view);
    }

    public function testTdAnonymousComponentWithClosureArguments(): void
    {
        $view = TD::make()
            ->component('exemplar::simple-anonymous-component', [
                'property1' => fn ($user) => $user->name,
                'property2' => fn ($user) => $user->email,
            ])
            ->buildTd($this->user);

        $this->assertStringContainsString($this->user->name, $view);
        $this->assertStringContainsString($this->user->email, $view);
    }

    public function testTdAnonymousComponentWithoutArguments(): void
    {
        $view = TD::make()
            ->component('exemplar::simple-anonymous-component')
            ->buildTd($this->user);

        $this->assertStringContainsString('property1: oops', $view);
        $this->assertStringContainsString('property2: default value', $view);
    }

    protected function checkedArgument(View $view)
    {
        $this->assertStringContainsString("Hello {$this->user->email} from Sasha", $view);
        $this->assertStringContainsString(app()->version(), $view);
    }
}
