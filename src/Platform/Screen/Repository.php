<?php

namespace Orchid\Platform\Screen;

class Repository extends \Illuminate\Config\Repository
{
    /**
     * @param $arg
     *
     * @return mixed|null
     */
    public function getContent($arg)
    {
        if ($this->has($arg)) {
            return $this->get($arg, 'null');
        }
    }
}
