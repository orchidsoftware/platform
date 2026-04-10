<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Presenter\Presentable;
use Orchid\Presenter\Presenter;
use Orchid\Presenter\UsePresenter;
use Orchid\Tests\TestUnitCase;
use RuntimeException;

class PresenterTest extends TestUnitCase
{
    // -------------------------------------------------------------------------
    // Existing tests
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // Presentable trait – #[UsePresenter] attribute
    // -------------------------------------------------------------------------

    public function testPresenterResolvesViaAttribute(): void
    {
        $model     = new ModelWithPresenterAttribute();
        $presenter = $model->presenter();

        $this->assertInstanceOf(StubPresenter::class, $presenter);
        $this->assertSame('from-attribute', $presenter->source);
    }

    // -------------------------------------------------------------------------
    // Presentable trait – runtime override
    // -------------------------------------------------------------------------

    public function testPresenterRuntimeOverride(): void
    {
        $model     = new ModelWithPresenterAttribute();
        $presenter = $model->presenter(AnotherStubPresenter::class);

        $this->assertInstanceOf(AnotherStubPresenter::class, $presenter);
    }

    public function testPresenterRuntimeOverridePersistsOnSameInstance(): void
    {
        $model = new ModelWithPresenterAttribute();

        $this->assertInstanceOf(
            AnotherStubPresenter::class,
            $model->presenter(AnotherStubPresenter::class)
        );
    }

    public function testPresenterSetDynamicallyWithoutAttribute(): void
    {
        $model     = new ModelWithoutPresenterAttribute();
        $presenter = $model->presenter(StubPresenter::class);

        $this->assertInstanceOf(StubPresenter::class, $presenter);
    }

    // -------------------------------------------------------------------------
    // Presentable trait – missing definition
    // -------------------------------------------------------------------------

    public function testPresenterThrowsWhenNoneIsDefined(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/No presenter found/');

        (new ModelWithoutPresenterAttribute())->presenter();
    }
}

// ---------------------------------------------------------------------------
// Test stubs (anonymous classes cannot carry PHP attributes)
// ---------------------------------------------------------------------------

class StubPresenter extends Presenter
{
    public string $source = 'from-attribute';
}

class AnotherStubPresenter extends Presenter {}

#[UsePresenter(StubPresenter::class)]
class ModelWithPresenterAttribute
{
    use Presentable;
}

class ModelWithoutPresenterAttribute
{
    use Presentable;
}
