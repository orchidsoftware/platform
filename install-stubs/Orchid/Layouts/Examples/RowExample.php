<?php

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;

class RowExample extends Rows
{
    /**
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [
            Field::group([

                Field::tag('input')
                    ->type('text')
                    ->name('name')
                    ->max(255)
                    ->title('Name Articles')
                    ->help('Article title'),

                Field::tag('input')
                    ->type('text')
                    ->name('title')
                    ->max(255)
                    ->title('Article Title')
                    ->help('SEO title'),

            ]),

            Field::group([

                Field::tag('select')
                    ->options([
                        'index'   => 'Index',
                        'noindex' => 'No index',
                    ])
                    ->multiple()
                    ->name('robot')
                    ->title('Indexing')
                    ->help('Allow search bots to index page'),

                Field::tag('input')
                    ->type('text')
                    ->name('phone')
                    ->mask('(999) 999-9999')
                    ->title('Phone')
                    ->help('Number Phone'),

                Field::tag('checkbox')
                    ->name('free')
                    ->value('230')
                    ->title('Free')
                    ->placeholder('Event for free')
                    ->help('Event for free'),

            ]),

            Field::tag('textarea')
                ->name('description')
                ->max(255)
                ->rows(5)
                ->title('Short description')
                ->horizontal(),

            Field::tag('wysiwyg')
                ->name('body')
                ->required()
                ->title('Name Articles')
                ->help('Article title')
                ->horizontal(),

            Field::tag('picture')
                ->name('picture')
                ->title('Picture')
                ->width(500)
                ->height(300)
                ->horizontal(),

            Field::tag('utm')
                ->name('link')
                ->title('UTM link')
                ->help('Generated link')
                ->horizontal(),

            Field::tag('datetime')
                ->name('open')
                ->title('Opening date')
                ->help('The opening event will take place')
                ->horizontal(),

            Field::tag('tags')
                ->name('keywords')
                ->title('Keywords')
                ->help('SEO keywords')
                ->horizontal(),

            Field::tag('markdown')
                ->name('body2')
                ->title('Name Articles')
                ->help('Article title')
                ->horizontal(),

            Field::tag('code')
                ->name('code')
                ->title('Name Articles')
                ->help('Article title')
                ->horizontal(),

        ];
    }
}
