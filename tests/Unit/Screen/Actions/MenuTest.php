<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Menu;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class MenuTest extends TestFieldsUnitCase
{
    public function testMenuInstance(): void
    {
        $link = Menu::make('About');
        $view = self::renderField($link);

        $this->assertStringContainsString('About', $view);
        $this->assertStringContainsString('#menu-about', $view);
    }

    public function testMenuPermissions(): void
    {
        // guest
        $link = Menu::make('About')->permission('unknown');

        $this->assertNull($link->render());
        $this->assertFalse($link->isSee());

        $link = Menu::make('About')->permission(['unknown', 'known']);

        $this->assertNull($link->render());
        $this->assertFalse($link->isSee());

        // without permission
        $user = User::factory()->create();
        Auth::login($user);
        $link = Menu::make('About')->permission('unknown');

        $this->assertNull($link->render());
        $this->assertFalse($link->isSee());

        $link = Menu::make('About')->permission(['unknown', 'known']);

        $this->assertNull($link->render());
        $this->assertFalse($link->isSee());

        // allow permission
        $user = User::factory()->create([
            'permissions' => ['unknown' => true],
        ]);
        Auth::login($user);
        $link = Menu::make('About')->permission('unknown');

        $this->assertNotNull($link->render());
        $this->assertTrue($link->isSee());

        $link = Menu::make('About')->permission(['unknown', 'known']);

        $this->assertNotNull($link->render());
        $this->assertTrue($link->isSee());
    }

    public function testMenuUrl(): void
    {
        $link = Menu::make('About')->href('https:://orchid.software');
        $view = self::renderField($link);

        $this->assertStringContainsString('href="https:://orchid.software"', $view);
    }

    public function testMenuTitle(): void
    {
        $link = Menu::make('About')->title('Navigation');
        $view = self::renderField($link);

        $this->assertStringContainsString('Navigation', $view);
    }

    public function testMenuBadge(): void
    {
        $link = Menu::make('About')->badge(fn () => 'Badge text');
        $view = self::renderField($link);

        $this->assertStringContainsString('Badge text', $view);
    }

    public function testMenuList(): void
    {
        $link = Menu::make('About')->list([
            Menu::make('Web site')
                ->href('https:://orchid.software'),

            Menu::make('GitHub')
                ->href('https://github.com/orchidsoftware/platform'),

            Menu::make('Admin')
                ->href('https:://orchid.software/admin')
                ->permission('unknown'),
        ]);
        $view = self::renderField($link);

        $this->assertStringContainsString('Web site', $view);
        $this->assertStringContainsString('GitHub', $view);
        $this->assertStringContainsString('https:://orchid.software', $view);
        $this->assertStringContainsString('https://github.com/orchidsoftware/platform', $view);

        $this->assertStringNotContainsString('https:://orchid.software/admin', $view);
    }

    public function testMenuSlug(): void
    {
        $link = Menu::make('About')->slug('navigation');
        $view = self::renderField($link);

        $this->assertStringContainsString('#menu-navigation', $view);
    }
}
