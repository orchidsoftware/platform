<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Support\Presenter;
use Orchid\Tests\TestUnitCase;

class PresenterTest extends TestUnitCase
{
    public function test_presenter_method(): void
    {
        $presenter = $this->getPresenterClass();

        $this->assertFalse($presenter->getStatus());
        $this->assertFalse($presenter->getStatus);
    }

    public function test_presenter_property(): void
    {
        $presenter = $this->getPresenterClass();

        $this->assertTrue(isset($presenter->status));
        $this->assertFalse($presenter->status);
    }

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
            public function getStatus(): bool
            {
                return $this->entity->status;
            }
        };
    }
}
