<?php

namespace Orchid\Tests\App;

use Orchid\Screen\Repository;

class RowDetailItem extends Repository
{
    public function getKey(): mixed
    {
        return $this->get('id');
    }
}
