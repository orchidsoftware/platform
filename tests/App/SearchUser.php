<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

use App\Orchid\Presenters\UserPresenter;
use Laravel\Scout\Searchable;
use Orchid\Platform\Models\User as Authenticatable;
use Orchid\Presenter\UsePresenter;

#[UsePresenter(UserPresenter::class)]
class SearchUser extends Authenticatable
{
    use Searchable;

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return $this->only([
            'id',
            'name',
            'email',
        ]);
    }
}
