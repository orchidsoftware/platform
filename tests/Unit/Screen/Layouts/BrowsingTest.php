<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Illuminate\Support\Str;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\TestUnitCase;

class BrowsingTest extends TestUnitCase
{
    public function testInstance(): void
    {
        $iframe = Layout::browsing('https://orchid.software');

        $html = $iframe->build(new Repository())->withErrors([])->render();

        $this->assertStringContainsString("src='https://orchid.software'", $html);
        $this->assertStringContainsString("loading='lazy'", $html);
        $this->assertStringNotContainsString('allow', $html);
    }

    public function testCanSeeInstance(): void
    {
        $iframe = Layout::browsing('https://orchid.software')->canSee(false);

        $html = $iframe->build(new Repository());

        $this->assertNull($html);
    }

    public function testAttributes():void
    {
        $attributes = [
            'allow'          => Str::random(),
            'loading'        => Str::random(),
            'csp'            => Str::random(),
            'name'           => Str::random(),
            'referrerpolicy' => Str::random(),
            'sandbox'        => Str::random(),
            'src'            => Str::random(),
            'srcdoc'         => Str::random(),
        ];

        $iframe = Layout::browsing('https://orchid.software');

        foreach ($attributes as $key => $value) {
            $iframe->$key($value);
        }

        $html = $iframe->build(new Repository())->withErrors([])->render();

        foreach ($attributes as $key => $value) {
            $this->assertStringContainsString("$key='$value'", $html);
        }
    }
}
