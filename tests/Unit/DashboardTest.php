<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Str;
use Orchid\Platform\Models\User;
use Orchid\Platform\Orchid;
use Orchid\Screen\Actions\Menu;
use Orchid\Tests\TestUnitCase;

/**
 * Class DashboardTest.
 */
class DashboardTest extends TestUnitCase
{
    public function test_is_version(): void
    {
        $this->assertEquals(Orchid::VERSION, Orchid::version());
    }

    public function test_is_model_default(): void
    {
        $class = Orchid::modelClass('UnknownClass', User::class);

        $default = new User;

        $this->assertEquals($class, $default);
    }

    public function test_is_model_custom_not_found(): void
    {
        Orchid::useModel(User::class, 'MyCustomClass');

        $user = Orchid::modelClass(User::class);

        $this->assertEquals('MyCustomClass', $user);
    }

    public function test_is_model_configure(): void
    {
        Orchid::configure([
            'models' => [
                User::class => 'MyCustomClass',
            ],
        ]);

        $class = Orchid::model(User::class);
        $option = Orchid::option('models.'.User::class);

        $this->assertEquals('MyCustomClass', $class);
        $this->assertEquals('MyCustomClass', $option);
        $this->assertEquals(null, Orchid::option('random'));
    }

    public function test_is_register_resource(): void
    {
        $dashboard = new Orchid;

        $script = $dashboard
            ->registerResource('scripts', 'app.js')
            ->getResource('scripts');

        $this->assertEquals([
            'app.js',
        ], $script);

        $stylesheets = $dashboard
            ->registerResource('stylesheets', 'style.css')
            ->getResource('stylesheets');

        $this->assertEquals([
            'style.css',
        ], $stylesheets);

        $this->assertEquals($dashboard->getResource(), collect([
            'scripts'     => [
                'app.js',
            ],
            'stylesheets' => [
                'style.css',
            ],
        ]));

        $rewriteScript = $dashboard
            ->registerResource('scripts', 'custom-app.js')
            ->getResource('scripts');

        $this->assertEquals([
            'app.js',
            'custom-app.js',
        ], $rewriteScript);

        $rewriteStyle = $dashboard
            ->registerResource('stylesheets', 'custom-style.css')
            ->getResource('stylesheets');

        $this->assertEquals([
            'style.css',
            'custom-style.css',
        ], $rewriteStyle);
    }

    /**
     * @param string $name
     */
    public function test_is_macro($name = 'customMarcoName'): void
    {
        Orchid::macro('returnNameMacroFunction', fn (string $test) => $test);

        $this->assertEquals(Orchid::returnNameMacroFunction($name), $name);
    }

    public function test_register_menu_element(): void
    {
        $dashboard = new Orchid;

        $view = $dashboard
            ->registerMenuElement(Menu::make('Item 1')->sort(3))
            ->registerMenuElement(Menu::make('Item 2')->sort(2))
            ->renderMenu();

        $this->assertStringContainsString('Item 2', $view);
        $this->assertStringContainsString('Item 1', $view);
        $this->assertTrue(Str::of($view)->after('Item 2')->contains('Item 1'));
    }

    public function test_add_menu_sub_elements(): void
    {
        $dashboard = new Orchid;

        $view = $dashboard
            ->registerMenuElement(Menu::make('Item 1')->slug('item'))
            ->addMenuSubElements('item', [
                Menu::make('Sub-element'),
            ])
            ->renderMenu();

        $this->assertStringContainsString('Sub-element', $view);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Orchid::configure([]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Orchid::configure([]);
    }
}
