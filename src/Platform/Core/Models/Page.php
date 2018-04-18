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

}
