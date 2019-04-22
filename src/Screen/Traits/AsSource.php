<?php

declare(strict_types=1);

namespace Orchid\Screen\Traits;

use Illuminate\Support\Arr;

/**
 * Trait AsSource.
 */
trait AsSource
{
    /**
     * @var array|null
     */
    protected $contentCache;

    /**
     * @param string $field
     *
     * @return mixed|null
     */
    public function getContent(string $field)
    {
        /** @var self \Illuminate\Database\Eloquent\Model */
        $model = $this->contentCache ?? $this->toArray();

        return Arr::get($model, $field) ?? Arr::get($this->getRelations(), $field);
    }
}
