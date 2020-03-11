<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use App\Orchid\Presenters\UserPresenter;
use Orchid\Platform\Models\User as Authenticatable;
use Laravel\Scout\Searchable;

class SearchUser extends Authenticatable
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

    /**
     * @return UserPresenter
     */
    public function presenter(): UserPresenter
    {
        return new UserPresenter($this);
    }
}
