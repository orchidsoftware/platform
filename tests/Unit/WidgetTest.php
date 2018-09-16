<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Tests\TestUnitCase;
use Orchid\Widget\Widget;

class WidgetTest extends TestUnitCase
{
    /**
     * @var Widget
     */
    public $baseWidget;

    /** @test */
    public function testWidgets()
    {
        foreach (config('platform.main_widgets') as $widget) {
            $widget = new $widget;

            //$this->assertAttributeInstanceOf($widget, Widget::class);
            $this->assertNotFalse($widget->handler());
        }
    }

    protected function setUp()
    {
        parent::setUp();
        $this->baseWidget = new Widget();
    }
}
