<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Builders;

use Illuminate\Database\Eloquent\Builder;

class CommentBuilder extends Builder
{
    /**
     * Where clause for only approved comments.
     *
     * @return \Orchid\Platform\Core\Builders\CommentBuilder
     */
    public function approved() : self
    {
        return $this->where('approved', 1);
    }
}
