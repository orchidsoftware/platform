<?php

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Models\User;
use Orchid\Support\Testing\DynamicTestScreen;
use Orchid\Support\Testing\ScreenTesting;
use Orchid\Tests\App\Screens\BaseScreenTesting;
use Orchid\Tests\TestUnitCase;

class HelperDynamicTestScreenTest extends TestUnitCase
{
    use ScreenTesting;

    public function testRouteRegister(): void
    {
        $wrap = new DynamicTestScreen('text_screen_name');
        $wrap->register(BaseScreenTesting::class);

        $this->assertTrue(Route::has('text_screen_name'));
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testUsageExample(): void
    {
        $screen = $this->screen()
            ->register(BaseScreenTesting::class);

        $screen->display()
            ->assertOk()
            ->assertSee('Base Screen Test');

        $screen
            ->method('showToast')
            ->assertSee('Hello, world! This is a toast message.');

        $screen
            ->method('showToast', [
                'toast' => 'Custom message',
            ])
            ->assertSee('Custom message');
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function textExampleWithRouteParams(): void
    {
        $user = User::factory();

        $screen = $this->screen()
            ->register(BaseScreenTesting::class, '/_test/users/{user}')
            ->parameters([
                'user' => $user,
            ]);

        $screen->display()
            ->assertSee($user->name)
            ->assertSee($user->email);

        $screen
            ->method('showToast')
            ->assertSee('Hello, world! This is a toast message.');

        $screen
            ->method('showToast', [
                'toast', 'Custom message',
            ])
            ->assertSee('Custom message');
    }
}
