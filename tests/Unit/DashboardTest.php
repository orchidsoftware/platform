<?php

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Tests\TestUnitCase;
use Orchid\Platform\Models\User;

class DashboardTest extends TestUnitCase
{
    public function testIsModelDefault()
    {
        $class = Dashboard::model('UnknownClass', User::class);

        $this->assertEquals($class, User::class);
    }

    public function testIsModelCustom()
    {
        Dashboard::useModel(User::class, 'MyCustomClass');

        $user = Dashboard::model(User::class);

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

        $this->assertEquals($class, 'MyCustomClass');
    }
}
