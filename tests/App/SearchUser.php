<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use App\Orchid\Presenters\UserPresenter;
use Laravel\Scout\Searchable;
use Orchid\Platform\Models\User as Authenticatable;

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
