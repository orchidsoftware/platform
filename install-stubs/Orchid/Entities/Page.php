<?php

declare(strict_types=1);

namespace App\Orchid\Entities;

use Orchid\Screen\Field;
use Orchid\Press\Entities\Single;
use Orchid\Screen\Fields\MapField;
use Orchid\Screen\Fields\UTMField;
use Orchid\Screen\Fields\CodeField;
use Orchid\Screen\Fields\TagsField;
use Orchid\Screen\Fields\InputField;
use Orchid\Screen\Fields\QuillField;
use Orchid\Screen\Fields\SelectField;
use Orchid\Screen\Fields\PictureField;
use Orchid\Screen\Fields\TinyMCEField;
use Orchid\Screen\Fields\CheckBoxField;
use Orchid\Screen\Fields\TextAreaField;
use Orchid\Screen\Fields\DateTimerField;
use Orchid\Screen\Fields\SimpleMDEField;

class Page extends Single
{
    /**
     * @var string
     */
    public $name = 'Example page';

    /**
     * @var string
     */
    public $description = 'Demonstrative page';

    /**
     * @var string
     */
    public $slug = 'example-page';

    /**
     * Slug url /news/{name}.
     *
     * @var string
     */
    public $slugFields = 'name';

    /**
     * Menu group name.
     *
     * @var null
     */
    public $groupname = 'Static Pages';

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'             => 'sometimes|integer|unique:posts',
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function fields(): array
    {
        return [

            Field::group([

                InputField::make('name')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title('Name Articles')
                    ->help('Article title'),

                InputField::make('title')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title('Article Title')
                    ->help('SEO title'),

            ]),

            Field::group([

                DateTimerField::make('open')
                    ->title('Opening date')
                    ->help('The opening event will take place'),

                InputField::make('phone')
                    ->type('text')
                    ->mask('(999) 999-9999')
                    ->title('Phone')
                    ->help('Number Phone'),

                CheckBoxField::make('free')
                    ->sendTrueOrFalse()
                    ->title('Free')
                    ->placeholder('Event for free')
                    ->help('Event for free'),
            ]),

            TextAreaField::make('description')
                ->max(255)
                ->rows(5)
                ->required()
                ->title('Short description'),

            TinyMCEField::make('body')
                ->required()
                ->title('Name Articles')
                ->help('Article title'),

            MapField::make('place')
                ->required()
                ->title('Object on the map')
                ->help('Enter the coordinates, or use the search'),

            PictureField::make('picture')
                ->name('picture')
                ->width(500)
                ->height(300),

            UTMField::make('link')
                ->title('UTM link')
                ->help('Generated link'),

            SelectField::make('robot.')
                ->options([
                    'index' => 'Index',
                    'noindex' => 'No index',
                ])
                ->multiple()
                ->title('Indexing')
                ->help('Allow search bots to index'),

            TagsField::make('keywords')
                ->title('Keywords')
                ->help('SEO keywords'),

            SimpleMDEField::make('body2')
                ->title('Name Articles')
                ->help('Article title'),

            QuillField::make('body3')
                ->title('Name Articles')
                ->help('Article title'),

            CodeField::make('code')
                ->title('Name Articles')
                ->help('Article title'),
        ];
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function options(): array
    {
        return [];
    }
}
