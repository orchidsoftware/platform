<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Comment;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\TextArea;

class CommentEditLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            TextArea::make('comment.content')
                ->max(255)
                ->rows(10)
                ->required()
                ->title(__('Content'))
                ->help(__('User comment')),

            CheckBox::make('comment.approved')
                ->title(__('Checking'))
                ->help(__('Show comment'))
                ->sendTrueOrFalse(),
        ];
    }
}
