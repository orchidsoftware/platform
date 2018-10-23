<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Comment;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class CommentEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        $fields[] = Field::tag('textarea')
            ->name('comment.content')
            ->max(255)
            ->rows(10)
            ->required()
            ->title(__('Content'))
            ->help(__('User comment'));

        $fields[] = Field::tag('checkbox')
            ->name('comment.approved')
            ->title(__('Checking'))
            ->help(__('Show comment'))
            ->sendTrueOrFalse();

        return $fields;
    }
}
