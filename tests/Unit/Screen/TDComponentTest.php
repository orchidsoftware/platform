<?php

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Models\User;
use Orchid\Screen\TD;
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


        $view = TD::make()
            ->component(UserTD::class, 'user')
            ->buildTd($this->user);

        $this->assertStringContainsString($this->user->email, $view);
    }

    public function testTdArgumentComponent(): void
    {
        $view = TD::make()
            ->component(UserTDArguments::class, 'user', [
                'from' => 'Sasha',
            ])
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    public function testTdArgumentView(): void
    {
        $view = TD::make()
            ->component(UserTDView::class, 'user', [
                'from' => 'Sasha',
            ])
            ->buildTd($this->user);

        $this->checkedArgument($view);
    }

    /**
     * @param View $view
     */
    protected function checkedArgument(View $view)
    {
        $this->assertStringContainsString("Hello {$this->user->email} from Sasha", $view);
        $this->assertStringContainsString(app()->version(), $view);
    }
}
