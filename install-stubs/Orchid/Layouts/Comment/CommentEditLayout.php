<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Comment;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\CheckBoxField;
use Orchid\Screen\Fields\TextAreaField;

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
        return [
            TextAreaField::make('comment.content')
                ->max(255)
                ->rows(10)
                ->required()
                ->title(__('Content'))
                ->help(__('User comment')),

            CheckBoxField::make('comment.approved')
                ->title(__('Checking'))
                ->help(__('Show comment'))
                ->sendTrueOrFalse(),
        ];
    }
}
