<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Support\Presenter;
use Orchid\Tests\TestUnitCase;

class PresenterTest extends TestUnitCase
{
    public function testPresenterMethod(): void
    {
        $presenter = $this->getPresenterClass();

        $this->assertFalse($presenter->getStatus());
        $this->assertFalse($presenter->getStatus);
    }

    public function testPresenterProperty(): void
    {
        $presenter = $this->getPresenterClass();

        $this->assertTrue(isset($presenter->status));
        $this->assertFalse($presenter->status);
    }

    /**
     * @return Presenter
     */
    protected function getPresenterClass(): Presenter
    {
        $class = new class
        {
            /**
             * @var bool
             */
            public $status = false;
        };

        return new class($class) extends Presenter
        {
            /**
             * @return bool
             */
            public function getStatus(): bool
            {
                return $this->entity->status;
            }
        };
    }
}
