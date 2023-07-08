<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Boolean;
use Orchid\Tests\TestUnitCase;

class BooleanTest extends TestUnitCase
{
    public function testRenderBooleanComponent(): void
    {
        $component = new Boolean(true);

        $this->assertEquals("<span class='text-success'>●</span>", $component->render());

        $component = new Boolean(false);

        $this->assertEquals("<span class='text-danger'>●</span>", $component->render());
    }

    public function testRenderBooleanWithNullComponent(): void
    {
        $component = new Boolean(null);

        $this->assertEquals("<span class='text-danger'>●</span>", $component->render());
    }

    public function testRenderBooleanWithLabelComponent(): void
    {
        $component = new Boolean(true, true: 'Enabled', false: 'Disabled');

        $this->assertEquals("<span class='text-success'>●</span>Enabled", $component->render());

        $component = new Boolean(false, true: 'Enabled', false: 'Disabled');

        $this->assertEquals("<span class='text-danger'>●</span>Disabled", $component->render());
    }
}
