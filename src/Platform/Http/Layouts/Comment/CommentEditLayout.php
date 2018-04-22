<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts\Comment;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class CommentEditLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Orchid\Press\Exceptions\TypeException
     *
     * @return array
     */
    public function fields(): array
    {
        $fields[] = Field::tag('textarea')
                         ->name('comment.content')
                         ->max(255)
                         ->rows(10)
                         ->required()
                         ->title(trans('dashboard::systems/comment.content'))
                         ->help(trans('dashboard::systems/comment.user_comment'));

        $fields[] = Field::tag('checkbox')
                    ->name('comment.approved')
                    ->title(trans('dashboard::systems/comment.checking'))
                    ->help(trans('dashboard::systems/comment.show_comment'));

        return $fields;
    }
}
