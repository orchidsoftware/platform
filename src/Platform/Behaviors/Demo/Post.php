<?php

declare(strict_types=1);

namespace Orchid\Platform\Behaviors\Demo;

use Orchid\Platform\Behaviors\Many;
use Orchid\Platform\Fields\Field;
use Orchid\Platform\Fields\TD;
use Orchid\Platform\Http\Filters\CreatedFilter;
use Orchid\Platform\Http\Filters\SearchFilter;
use Orchid\Platform\Http\Filters\StatusFilter;
use Orchid\Platform\Http\Forms\Posts\BasePostForm;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class Post extends Many
{
    /**
     * @var string
     */
    public $name = 'Demo post';

    /**
     * @var string
     */
    public $description = 'Demonstrative post';

    /**
     * @var string
     */
    public $slug = 'demo';

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
    public $groupname = 'dashboard::menu.common posts';

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
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [
            SearchFilter::class,
            StatusFilter::class,
            CreatedFilter::class,
        ];
    }

    /**
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
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
                        ->help('SEO title')

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
     * @deprecated
     *
     * @return array
     */
    public function modules() : array
    {
        return [
            BasePostForm::class,
            UploadPostForm::class,
        ];
    }

    /**
     * @return array
     */
    public function options(): array
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
                       ->help('SEO title')

               ];
           }),
       ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            TD::set('id','ID')
                ->align('center')
                ->width('100px')
                ->filter('numeric')
                ->sort()
                ->linkPost(),

            TD::set('name', 'Name')
                ->locale()
                ->column('content.name')
                ->filter('text')
                ->sort()
                ->linkPost('name'),

            TD::set('publish_at', 'Date of publication')
                ->filter('date')
                ->sort(),

            TD::set('created_at', 'Date of creation')
                ->filter('date')
                ->sort(),
        ];
    }
}
