<?php

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\UTM;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Tags;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TinyMCE;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\SimpleMDE;

class RowExample extends Rows
{
    /**
     * @throws \Throwable
     *
     * @return array
     */
    public function fields(): array
    {
        return [

            Field::group([

                Input::make('name')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title('Name Articles')
                    ->help('Article title')
                    ->popover('Tooltip - hint that user opens himself.'),

                Input::make('title')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title('Article Title')
                    ->help('SEO title')
                    ->popover('Tooltip - hint that user opens himself.'),

            ]),

            Field::group([

                DateTimer::make('open')
                    ->title('Opening date')
                    ->help('The opening event will take place'),

                Input::make('phone')
                    ->type('text')
                    ->mask('(999) 999-9999')
                    ->title('Phone')
                    ->help('Number Phone'),

                CheckBox::make('free-checkbox')
                    ->sendTrueOrFalse()
                    ->title('Free checkbox')
                    ->placeholder('Event for free')
                    ->help('Event for free'),

                Switcher::make('free-switch')
                    ->sendTrueOrFalse()
                    ->title('Free switch')
                    ->placeholder('Event for free')
                    ->help('Event for free'),
            ]),

            TextArea::make('description')
                ->max(255)
                ->rows(5)
                ->required()
                ->title('Short description'),

            TinyMCE::make('body')
                ->required()
                ->title('Name Articles')
                ->help('Article title'),

            Map::make('place')
                ->required()
                ->title('Object on the map')
                ->help('Enter the coordinates, or use the search'),

            Picture::make('picture')
                ->name('picture')
                ->width(500)
                ->height(300),

            UTM::make('link')
                ->title('UTM link')
                ->help('Generated link'),

            Select::make('robot.')
                ->options([
                    'index'   => 'Index',
                    'noindex' => 'No index',
                ])
                ->multiple()
                ->title('Indexing')
                ->help('Allow search bots to index'),

            Tags::make('keywords')
                ->title('Keywords')
                ->help('SEO keywords'),

            SimpleMDE::make('body2')
                ->title('Name Articles')
                ->help('Article title'),

            Code::make('code')
                ->title('Name Articles')
                ->help('Article title'),

            Quill::make('body3')
                ->title('Name Articles')
                ->help('Article title'),

        ];
    }
}
