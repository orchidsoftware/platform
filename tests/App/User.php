<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use Orchid\Platform\Models\User as Authenticatable;
use Orchid\Platform\Searchable;

class User extends Authenticatable
{
    use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only([
            'id',
            'name',
            'email',
        ]);
    }
}
