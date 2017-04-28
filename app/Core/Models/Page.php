<?php

namespace Orchid\Core\Models;

use Orchid\Exceptions\TypeException;
use Orchid\Facades\Dashboard;

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
        $this->behavior = Dashboard::getPages()->find($slug);

        if (is_null($this->behavior)) {
            throw new TypeException("{$slug} Type is not found");
        }

        return $this;
    }
}
