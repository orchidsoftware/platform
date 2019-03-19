<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Platform;

use Orchid\Platform\Updates;
use Orchid\Tests\TestUnitCase;

class UpdateTest extends TestUnitCase
{
    public function testUpdate(): void
    {
        $update = new Updates();
        $isLastVersion = $update->check();

        $this->assertIsBool($isLastVersion);
    }
}
