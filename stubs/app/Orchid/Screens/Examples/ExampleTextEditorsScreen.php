<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\ExampleElements;
use Illuminate\Support\Str;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ExampleTextEditorsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'quill'     => 'Hello! We collected all the fields in one place',
            'simplemde' => '# Big header',
            'code'      => Str::limit(file_get_contents(__FILE__), 500),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Form Text Editors';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Examples for creating a wide variety of forms.';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @throws \Throwable
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            ExampleElements::class,

            Layout::rows([
                SimpleMDE::make('simplemde')
                    ->title('SimpleMDE')
                    ->popover('SimpleMDE is a simple, embeddable, and beautiful JS markdown editor'),

                Quill::make('quill')
                    ->title('Quill')
                    ->popover('Quill is a free, open source WYSIWYG editor built for the modern web.'),

                Code::make('code')
                    ->title('Code'),

            ]),
        ];
    }
}
