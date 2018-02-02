<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Models;

use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Exceptions\TypeException;

class Page extends Post
{
    /**
     * @var string
     */
    protected $postType = 'page';

    /**
     * @param $slug
     *
     * @return $this
     * @throws TypeException
     */
    public function getBehavior($slug)
    {
        $this->behavior = Dashboard::getStorage('pages')->find($slug);

        if (is_null($this->behavior)) {
            throw new TypeException("{$slug} Type is not found");
        }

        return $this;
    }
}
