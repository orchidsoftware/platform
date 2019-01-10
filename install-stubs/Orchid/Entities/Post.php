<?php

declare(strict_types=1);

namespace App\Orchid\Entities;

use Orchid\Screen\TD;
use Orchid\Screen\Field;
use Orchid\Press\Entities\Many;
use Orchid\Press\Models\Category;
use Orchid\Screen\Fields\MapField;
use Orchid\Screen\Fields\UTMField;
use Orchid\Screen\Fields\CodeField;
use Orchid\Screen\Fields\TagsField;
use Orchid\Screen\Fields\InputField;
use Orchid\Screen\Fields\QuillField;
use Orchid\Screen\Fields\SelectField;
use Orchid\Screen\Fields\UploadField;
use Orchid\Screen\Fields\PictureField;
use Orchid\Screen\Fields\TinyMCEField;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Fields\CheckBoxField;
use Orchid\Screen\Fields\TextAreaField;
use Orchid\Screen\Fields\DateTimerField;
use Orchid\Screen\Fields\SimpleMDEField;
use Orchid\Press\Http\Filters\SearchFilter;
use Orchid\Press\Http\Filters\StatusFilter;
use Orchid\Press\Http\Filters\CreatedFilter;

class Post extends Many
{
    /**
     * @var string
     */
    public $name = 'Example post';

    /**
     * @var string
     */
    public $description = 'Demonstrative post';

    /**
     * @var string
     */
    public $slug = 'example-post';

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
    public $groupname = 'Common Posts';

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(Model $model) : Model
    {
        return $model->load(['attachment', 'tags', 'taxonomies'])
            ->setAttribute('category', $model->taxonomies->map(function ($item) {
                return $item->id;
            })->toArray());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function save(Model $model)
    {
        $model->save();

        $model->taxonomies()->sync(array_flatten(request(['category'])));
        $model->setTags(request('tags', []));
        $model->attachment()->syncWithoutDetaching(request('attachment', []));
    }

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
     * HTTP data filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            SearchFilter::class,
            StatusFilter::class,
            CreatedFilter::class,
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
     * @throws \Orchid\Screen\Exceptions\TypeException
     * @throws \Throwable
     */
    public function main(): array
    {
        return array_merge(parent::main(), [
            SelectField::make('category.')
                ->options(function () {
                    $options = (new Category())->getAllCategories();

                    return array_replace([0=> __('Without category')], $options);
                })
                ->multiple()
                ->title('Category')
                ->help('Select category'),

            TagsField::make('tags')
                ->title('Tags')
                ->help('Keywords'),

            UploadField::make('attachment')
                ->title('Upload DropBox'),
        ]);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function options(): array
    {
        return [
            TextAreaField::make('description')
                ->max(255)
                ->rows(5)
                ->required()
                ->title('Short description'),

            DateTimerField::make('open')
                ->title('Opening date')
                ->help('The opening event will take place'),
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid(): array
    {
        return [
            TD::set('id', 'ID')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->filter('numeric')
                ->sort()
                ->linkPost(),

            TD::set('name', 'Name')
                ->width('250px')
                ->locale()
                ->column('content.name')
                ->filter('text')
                ->sort()
                ->linkPost('name'),

            TD::set('status')
                ->sort(),

            TD::set('phone', 'Phone')
                ->locale()
                ->column('content.phone')
                ->filter('text')
                ->linkPost('phone'),

            TD::set('publish_at', 'Date of publication')
                ->filter('date')
                ->sort()
                ->align(TD::ALIGN_RIGHT)
                ->setRender(function ($item) {
                    return optional($item->publish_at)->toDateString();
                }),

            TD::set('created_at', 'Date of creation')
                ->filter('date')
                ->align(TD::ALIGN_RIGHT)
                ->sort()
                ->setRender(function ($item) {
                    return $item->created_at->toDateString();
                }),
        ];
    }
}
