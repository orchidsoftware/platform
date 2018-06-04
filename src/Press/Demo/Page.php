<?php

declare(strict_types=1);

namespace Orchid\Press\Demo;

use Orchid\Platform\Fields\Field;
use Orchid\Press\Entities\Single;
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
     * Menu group name.
     *
     * @var null
     */
    public $groupname = 'platform::menu.static pages';

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
     * @throws \Orchid\Platform\Exceptions\TypeException
     *
     * @return array
     */
    public function fields() : array
    {
        return [

            Field::group(function () {
                return [

                    Field::tag('input')
                        ->type('text')
                        ->name('name')
                        ->max(255)
                        ->required()
                        ->title('Name Articles')
                        ->help('Article title'),

                    Field::tag('input')
                        ->type('text')
                        ->name('title')
                        ->max(255)
                        ->required()
                        ->title('Article Title')
                        ->help('SEO title'),

                ];
            }),

            Field::group(function () {
                return [

                    Field::tag('select')
                        ->options([
                            'index'   => 'Index',
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

                    Field::tag('checkbox')
                        ->name('free')
                        ->value('230')
                        ->title('Free')
                        ->placeholder('Event for free')
                        ->help('Event for free'),

                ];
            }),

            Field::tag('textarea')
                ->name('description')
                ->max(255)
                ->rows(5)
                ->required()
                ->title('Short description'),

            Field::tag('wysiwyg')
                ->name('body')
                ->required()
                ->title('Name Articles')
                ->help('Article title'),

            Field::tag('picture')
                ->name('picture')
                ->width(500)
                ->height(300),

            Field::tag('utm')
                ->name('link')
                ->title('UTM link')
                ->help('Generated link'),

            Field::tag('datetime')
                ->name('open')
                ->title('Opening date')
                ->help('The opening event will take place'),

            Field::tag('tags')
                ->name('keywords')
                ->title('Keywords')
                ->help('SEO keywords'),

            Field::tag('markdown')
                ->name('body2')
                ->title('Name Articles')
                ->help('Article title'),

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
    public function options(): array
    {
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
