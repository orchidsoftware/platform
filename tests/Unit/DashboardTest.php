<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

/**
 * Class DashboardTest.
 */
class DashboardTest extends TestUnitCase
{
    public function testIsVersion()
    {
        $this->assertEquals(Dashboard::version(), Dashboard::VERSION);
    }

    public function testIsModelDefault()
    {
        $class = Dashboard::modelClass('UnknownClass', User::class);

        $default = new User();

        $this->assertEquals($class, $default);
    }

    public function testIsModelCustomNotFound()
    {
        Dashboard::useModel(User::class, 'MyCustomClass');

        $user = Dashboard::modelClass(User::class);

        $this->assertEquals($user, 'MyCustomClass');
    }

    public function testIsModelConfigure()
    {
        Dashboard::configure([
            'models' => [
                User::class => 'MyCustomClass',
            ],
        ]);

        $class = Dashboard::model(User::class);
        $option = Dashboard::option('models.'.User::class);

        $this->assertEquals($class, 'MyCustomClass');
        $this->assertEquals($option, 'MyCustomClass');
        $this->assertEquals(Dashboard::option('random'), null);
    }

    public function testIsRegisterResource()
    {
        $dashboard = new Dashboard();

        $script = $dashboard
            ->registerResource('scripts', 'app.js')
            ->getResource('scripts');

        $this->assertEquals($script, [
            'app.js',
        ]);

        $stylesheets = $dashboard
            ->registerResource('stylesheets', 'style.css')
            ->getResource('stylesheets');

        $this->assertEquals($stylesheets, [
            'style.css',
        ]);

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

        $this->assertEquals($rewriteScript, [
            'app.js',
            'custom-app.js',
        ]);

        $rewriteStyle = $dashboard
            ->registerResource('stylesheets', 'custom-style.css')
            ->getResource('stylesheets');

        $this->assertEquals($rewriteStyle, [
            'style.css',
            'custom-style.css',
        ]);
    }

    /**
     * @param string $name
     */
    public function testIsMacro($name = 'customMarcoName')
    {
        Dashboard::macro('returnNameMacroFunction', function (string $test) {
            return $test;
        });

        $this->assertEquals(Dashboard::returnNameMacroFunction($name), $name);
    }

    protected function setUp() : void
    {
        parent::setUp();
        Dashboard::configure([]);
    }

    protected function tearDown() : void
    {
        parent::tearDown();
        Dashboard::configure([]);
    }
}
