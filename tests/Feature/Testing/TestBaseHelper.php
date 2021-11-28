<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Support\Testing\ScreenTesting;
use Orchid\Tests\App\Screens\BaseScreenTesting;
use Orchid\Tests\TestFeatureCase;

class TestBaseHelper extends TestFeatureCase
{
    use ScreenTesting;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function example()
    {
        $screen = $this->screen()
            ->register(BaseScreenTesting::class);

        $screen->display()
            ->assertSee('Base Screen Test');

        $screen
            ->method('showToast')
            ->assertSee('Hello, world! This is a toast message.');

        $screen
            ->method('showToast', [
                'toast', 'Custom message',
            ])
            ->assertSee('Custom message');
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function exampleWithRouteParams()
    {
        $user = $this->createAdminUser();

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
