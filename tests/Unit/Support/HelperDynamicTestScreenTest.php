<?php

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Route;
use Orchid\Support\Testing\DynamicTestScreen;
use Orchid\Tests\App\Screens\BaseScreenTesting;
use Orchid\Tests\TestUnitCase;

class HelperDynamicTestScreenTest extends TestUnitCase
{
    public function testRouteRegister(): void
    {
        $wrap = new DynamicTestScreen('text_screen_name');
        $wrap->register(BaseScreenTesting::class);

        $this->assertTrue(Route::has('text_screen_name'));
    }
}
