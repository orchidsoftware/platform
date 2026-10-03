<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Concerns;

use Orchid\Screen\Action;
use Orchid\Screen\Concerns\HasEmptyState;
use Orchid\Tests\TestUnitCase;

class HasEmptyStateTest extends TestUnitCase
{
    private EmptyState $emptyState;

    private array $query;

    protected function setUp(): void
    {
        parent::setUp();

        $this->query = request()->query->all();

        $this->emptyState = new EmptyState;
    }

    protected function tearDown(): void
    {
        request()->query->replace($this->query);

        parent::tearDown();
    }

    public function testDescribesAnEmptyCollectionWithoutFilters(): void
    {
        $this->assertSame('bs.journal-x', $this->emptyState->icon());
        $this->assertSame('No items yet', $this->emptyState->title());
        $this->assertSame('New items will appear here.', $this->emptyState->description());
        $this->assertNull($this->emptyState->action());
        $this->assertFalse($this->emptyState->filtered());
    }

    public function testDescribesAnEmptyFilteredCollection(): void
    {
        request()->query->replace([
            'filter' => ['name' => 'missing'],
            'page'   => 2,
            'sort'   => 'name',
            'tab'    => 'active',
        ]);

        $action = $this->emptyState->action();

        $this->assertTrue($this->emptyState->filtered());
        $this->assertSame('No matches', $this->emptyState->title());
        $this->assertSame('Try changing or clearing the filters.', $this->emptyState->description());
        $this->assertNotNull($action);
        $this->assertStringContainsString('sort=name', $action->get('href'));
        $this->assertStringContainsString('tab=active', $action->get('href'));
        $this->assertStringNotContainsString('filter', $action->get('href'));
        $this->assertStringNotContainsString('page=2', $action->get('href'));
    }

    public function testIgnoresEmptyFilterValues(): void
    {
        request()->query->replace([
            'filter' => [
                'name'  => '',
                'range' => ['start' => null, 'end' => ''],
            ],
        ]);

        $this->assertFalse($this->emptyState->filtered());
        $this->assertSame('No items yet', $this->emptyState->title());
        $this->assertNull($this->emptyState->action());
    }
}

final class EmptyState
{
    use HasEmptyState;

    public function icon(): string
    {
        return $this->emptyStateIcon();
    }

    public function title(): string
    {
        return $this->emptyStateTitle();
    }

    public function description(): string
    {
        return $this->emptyStateDescription();
    }

    public function action(): ?Action
    {
        return $this->emptyStateAction();
    }

    public function filtered(): bool
    {
        return $this->hasActiveFilters();
    }
}
