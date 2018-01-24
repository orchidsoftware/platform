<?php

namespace Orchid\Platform\Screen;

use Illuminate\Config\Repository as BaseRepository;

class Repository extends BaseRepository
{
    /**
     * @param $arg
     *
     * @return mixed|null
     */
    public function getContent($arg)
    {
        if ($this->has($arg)) {
            return $this->get($arg);
        }
    }
}
