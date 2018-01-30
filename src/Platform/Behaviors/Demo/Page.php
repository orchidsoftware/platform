<?php

namespace Orchid\Platform\Behaviors\Demo;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Behaviors\Single;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class Page extends Single
{
    /**
     * @var string
     */
    public $name = 'Demo page';

    /**
     * @var string
     */
    public $description = 'Demonstrative page';

    /**
     * @var string
     */
    public $slug = 'demo-page';

    /**
     * Slug url /news/{name}.
     *
     * @var string
     */
    public $slugFields = 'name';

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'id'             => 'sometimes|integer|unique:posts',
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     */
    public function fields() : array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('name')
                ->max(255)
                ->required()
                ->title('Name Articles')
                ->help('Article title'),

            Field::tag('wysiwyg')
                ->name('body')
                ->required()
                ->title('Name Articles')
                ->help('Article title'),

            Field::tag('markdown')
                ->name('body2')
                ->title('Name Articles')
                ->help('Article title'),

            Field::tag('picture')
                ->name('picture')
                ->width(500)
                ->height(300),

            Field::tag('datetime')
                ->type('text')
                ->name('open')
                ->title('Opening date')
                ->help('The opening event will take place'),

            Field::tag('checkbox')
                ->name('free')
                ->value(1)
                ->title('Free')
                ->placeholder('Event for free')
                ->help('Event for free'),

            Field::tag('code')
                ->name('block')
                ->title('Code Block')
                ->help('Simple web editor'),

            Field::tag('input')
                ->type('text')
                ->name('title')
                ->max(255)
                ->required()
                ->title('Article Title')
                ->help('SEO title'),

            Field::tag('textarea')
                ->name('description')
                ->max(255)
                ->row(5)
                ->required()
                ->title('Short description'),

            Field::tag('tags')
                ->name('keywords')
                ->title('Keywords')
                ->help('SEO keywords'),

            Field::tag('select')
                ->options([
                    'index' => 'Index',
                    'noindex' => 'No index',
                ])
                ->name('robot')
                ->title('Indexing')
                ->help('Allow search bots to index page'),

            Field::tag('input')
                ->type('text')
                ->name('phone')
                ->mask('(999) 999-9999')
                ->title('Phone')
                ->help('Number Phone'),

            /* need api key 'place'
            Field::tag('place')
                ->name('place')
                ->title('Place')
                ->help('place for google maps'),
            */
        ];
    }

    /**
     * @return array
     */
    public function modules() : array
    {
        return [
            UploadPostForm::class,
        ];
    }
}
