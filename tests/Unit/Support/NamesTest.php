<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Support\Names;
use Orchid\Tests\TestUnitCase;

class NamesTest extends TestUnitCase
{
    public function test_names_for_page_class(): void
    {
        $this->setRouteName('empty');

        $this->assertSame('page-empty', Names::getPageNameClass());
    }

    public function test_names_separate_for_page_class(): void
    {
        $this->setRouteName('platform.empty');

        $this->assertSame('page-platform-empty', Names::getPageNameClass());
    }

    public function test_names_slug_for_page_class(): void
    {
        $this->setRouteName('platform empty');

        $this->assertSame('page-platform-empty', Names::getPageNameClass());
    }

    protected function setRouteName(string $name)
    {
        Route::get($name, function () {})->name($name);

        $request = tap(new Request, function (Request $request) use ($name) {
            $request->server->set('REQUEST_URI', \route($name));
        });

        Route::dispatchToRoute($request);
    }
}
