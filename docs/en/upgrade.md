# Upgrade tutorial
----------


> **Notice.** We are doing all we can to document all thte changes that may cause problems. 
But we highly recommend to not perform any changes without a backup.


# Upgrade from 2.0 to 2.1

## Changes 

### Field definition

With this update ORCHID introduces the new field notation and table formatting.
More information about it may be found in issue #391

**Old notation**
```php
'body' => 'tag:tag|wysiwyg|name:body|max:255|required|rows:10',
```

**New notation:**
```php
Field::tag('wysiwyg')
    ->name('body')
    ->max(255)
    ->required()
    ->rows(10),
```

Deprecated notation will be supported for some time but the best solution for a long-term support is to wrap an old notatin the following way:

```php
'body' => Field::make('tag:tag|wysiwyg|name:body|max:255|required|rows:10'),
```

Table rows have also changed and now havw the following notation:

```php
TD::name('appointment_type')
->title('Type')

// Extended variant
TD::name('appointment_time')
    ->title('Time')
    ->width('200px')
    ->setRender(function ($appointment){
    return $appointment->appointment_time->toDateString();
}),
```


### Entities

Many entities now don't have a default property:

```php
/**
 * HTTP data filters
 *
 * @var array
 */
public $filters = [
    SearchFilter::class,
    StatusFilter::class,
    CreatedFilter::class,
];
```

For standartization it was replaced with the following method:

```php
/**
 * HTTP data filters
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
```


## Deleted functions

### Fields
Impractical features that were previously declined deprecated are now deleted:
- `robot` field
- Widget for Google Analytics

The more functionat alternative to `robot` field is:

```php
Field::tag('select')
    ->options([
        'index' => 'Index',
        'noindex' => 'No index',
    ])
    ->name('robot')
    ->title('Indexing')
    ->help('Allow search bots to index page'),
```


Field section in configuration now must look like that:

```php
'fields' => [
    'textarea'     => Orchid\Screen\Fields\Types\TextAreaField::class,
    'input'        => Orchid\Screen\Fields\Types\InputField::class,
    'list'         => Orchid\Screen\Fields\Types\ListField::class,
    'tags'         => Orchid\Screen\Fields\Types\TagsField::class,
    'select'       => Orchid\Screen\Fields\Types\SelectField::class,
    'relationship' => Orchid\Screen\Fields\Types\RelationshipField::class,
    'place'        => Orchid\Screen\Fields\Types\PlaceField::class,
    'picture'      => Orchid\Screen\Fields\Types\PictureField::class,
    'datetime'     => Orchid\Screen\Fields\Types\DateTimerField::class,
    'checkbox'     => Orchid\Screen\Fields\Types\CheckBoxField::class,
    'code'         => Orchid\Screen\Fields\Types\CodeField::class,
    'wysiwyg'      => Orchid\Screen\Fields\Types\TinyMCEField::class,
    'password'     => Orchid\Screen\Fields\Types\PasswordField::class,
    'markdown'     => Orchid\Screen\Fields\Types\SimpleMDEField::class,
],
```
