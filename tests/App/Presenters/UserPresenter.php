<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Presenters;

use Laravel\Scout\Builder;
use Orchid\Screen\Contracts\Personable;
use Orchid\Screen\Contracts\Searchable;
use Orchid\Support\Presenter;

class UserPresenter extends Presenter implements Personable, Searchable
{
    public function label(): string
    {
        return 'Users';
    }

    public function title(): string
    {
        return $this->entity->name;
    }

    public function subTitle(): string
    {
        return 'Administrator';
    }

    public function url(): string
    {
        return route('platform.systems.users.edit', $this->entity);
    }

    /**
     * @return string
     */
    public function image(): ?string
    {
        $hash = md5(strtolower(trim($this->entity->email)));

        return "https://www.gravatar.com/avatar/$hash";
    }

    /**
     * {@inheritdoc}
     */
    public function perSearchShow(): int
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->entity->search($query);
    }
}
