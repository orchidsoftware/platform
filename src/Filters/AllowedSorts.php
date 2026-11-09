<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Attribute;

/**
 * Declare the columns accepted by URL sorting.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class AllowedSorts
{
    /**
     * @param list<string> $columns
     */
    public function __construct(public array $columns) {}
}
