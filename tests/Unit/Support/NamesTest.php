<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Http\Request;
use Orchid\Support\Names;
use Illuminate\Support\Facades\Route;
use Orchid\Tests\TestUnitCase;

class NamesTest extends TestUnitCase
{
    public function testNamesForPageClass(): void
    {
        $this->setRouteName('empty');

        $this->assertSame('page-empty', Names::getPageNameClass());
    }

    public function testNamesSeparateForPageClass(): void
    {
        $this->setRouteName('platform.empty');

        $this->assertSame('page-platform-empty', Names::getPageNameClass());
    }

    public function testNamesSlugForPageClass(): void
    {
        $this->setRouteName('platform empty');

        $this->assertSame('page-platform-empty', Names::getPageNameClass());
    }

    protected function setRouteName(string $name)
    {
        Route::get($name, function () {

        })->name($name);

        $request = tap(new Request(), function (Request $request) use ($name) {
            $request->server->set('REQUEST_URI', \route($name));
        });

        Route::dispatchToRoute($request);
    }
}
