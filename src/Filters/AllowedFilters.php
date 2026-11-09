<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Attribute;

/**
 * Declare the columns and filter types accepted from the URL.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class AllowedFilters
{
    /**
     * @param array<string, class-string<Filter>> $columns
     */
    public function __construct(public array $columns) {}
}
