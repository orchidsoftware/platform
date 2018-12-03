<?php

declare(strict_types=1);

namespace Tests\Feature\Platform;

use Orchid\Platform\Updates;
use Orchid\Tests\TestUnitCase;

class UpdateTest extends TestUnitCase
{
    /**
     *
     */
    public function testUpdate(): void
    {
        $update = new Updates();
        $isLastVersion = $update->check();

        $this->assertInternalType('bool', $isLastVersion);
    }
}