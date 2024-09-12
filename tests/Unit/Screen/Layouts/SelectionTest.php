<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Filters\Filter;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Tests\App\Filters\HiddenFilter;
use Orchid\Tests\App\Layouts\GroupNameAndEmail;
use Orchid\Tests\TestUnitCase;

class SelectionTest extends TestUnitCase
{
    public function testNoDisplayOnlyHiddenFilter(): void
    {
        $layout = LayoutFactory::selection([
            HiddenFilter::class,
        ]);

        $html = $layout->build(new Repository);

        $this->assertNull($html);
    }

    public function testDisplayFilters(): void
    {
        $layout = new GroupNameAndEmail;

        // Test with empty request
        $html = (string) $layout->build(new Repository);

        collect($layout->filters())
            ->map(fn (string $filter) => resolve($filter))->each(function (Filter $filter) use ($html) {
                $this->assertStringContainsString($filter->render(), $html);
            });

        // Test with parameterized request
        request()->merge([
            'name'  => 'John Snow',
            'email' => 'john@bastard.com',
        ]);

        $htmlParameterized = (string) $layout->build(new Repository);

        collect($layout->filters())
            ->map(fn (string $filter) => resolve($filter))->each(function (Filter $filter) use ($html, $htmlParameterized) {
                $render = $filter->render();
                $this->assertStringContainsString($render, $htmlParameterized);
                $this->assertStringNotContainsString($render, $html);
            });
    }
}
