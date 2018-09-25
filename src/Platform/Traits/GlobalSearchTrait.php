<?php

declare(strict_types=1);

namespace Orchid\Platform\Traits;

use Laravel\Scout\Searchable;

trait GlobalSearchTrait
{
    use Searchable;

    /**
     * @return string
     */
    public function searchLabel(): string
    {
        return $this->attribute('label');
    }

    /**
     * @return string
     */
    public function searchTitle(): string
    {
        return $this->attribute('title', 'See documentation method search* in Orchid\Platform\Traits\GlobalSearchTrait');
    }

    /**
     * @return string
     */
    public function searchSubTitle(): string
    {

        return $this->attribute('subTitle');
    }

    /**
     * @return string
     */
    public function searchUrl(): string
    {
        return $this->attribute('url', '#');
    }

    /**
     * @return string
     */
    public function searchAvatar(): string
    {
        return $this->attribute('avatar');
    }

    /**
     *
     */
    public function searchQuery($test)
    {
        return $test;
    }
}