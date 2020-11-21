<?php

declare(strict_types=1);

namespace Orchid\Support\Concerns;

use Illuminate\Support\Arr;

trait ValidDataPart
{
    /**
     * Get the validated data from the request.
     *
     * @param string|int|null  $key
     * @param mixed  $default
     *
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $validated = $this->validator->validated();

        return $key !== null
            ? Arr::get($validated, $key, $default)
            : $validated;
    }
}
