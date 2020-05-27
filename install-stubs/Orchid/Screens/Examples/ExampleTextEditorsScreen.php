<?php

namespace App\Orchid\Screens\Examples;

use Illuminate\Support\Str;
use Orchid\Screen\Action;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\TinyMCE;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class ExampleTextEditorsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Form Text Editors';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Examples for creating a wide variety of forms.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'quill'     => 'Hello! We collected all the fields in one place',
            'simplemde' => '# Big header',
            'code'      => Str::limit(file_get_contents(__FILE__), 500),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                SimpleMDE::make('simplemde')
                    ->title('SimpleMDE')
                    ->popover('SimpleMDE is a simple, embeddable, and beautiful JS markdown editor'),

                Quill::make('quill')
                    ->title('Quill')
                    ->popover('Quill is a free, open source WYSIWYG editor built for the modern web.'),

                Code::make('code')
                    ->title('Name Articles'),

                TinyMCE::make('tinymce')
                    ->required()
                    ->title('Name Articles')
                    ->popover('TinyMCE for free, the most advanced WYSIWYG HTML editor designed to simplify website content creation.'),

                TinyMCE::make('tinymce_with_toolbar')
                    ->title('TinyMCE with Toolbar')
                    ->help('Article title')
                    ->theme('modern'),
            ]),
        ];
    }
}
