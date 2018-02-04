# Upgrade Guide
----------


We try to document all the changes that can cause problems.
But we strongly recommend that you do not make changes without saving a copy.


> ** Note **. Issue 2.1 has not yet settled, please wait.

# Upgrading from 2.0 to 2.1

## Changes

### Declaring Fields

With the new update, ORCHID enters a new field entry and table formatting.
More details can be found in issue # 391

** Old look: **
```php
'body' => 'tag: tag | wysiwyg | name: body | max: 255 | required | rows: 10',
```

**The new kind:**
```php
Field::tag ('wysiwyg')
    ->name ('body')
    ->max (255)
    ->required ()
    ->rows (10),
```

An obsolete view will be maintained for a while, but the best option for long-term support
will wrap the old version like this:

```php
'body' => Field::make ('tag: tag | wysiwyg | name: body | max: 255 | required | rows: 10'),
```

The columns of the tables have also undergone changes and have a record:

```php
TD::name ('appointment_type')
->title ('Type')

//Advanced option
TD::name ('appointment_time')
    ->title ('Time')
    ->width ('200px')
    ->setRender (function ($appointment) {
    return $appointment->appointment_time->toDateString ();
}),
```


### Behaviors

Multiple behaviors no longer have a default property:

```php
/ **
 * HTTP data filters
 *
 * @var array
 * /
public $filters = [
    SearchFilter::class,
    StatusFilter::class,
    CreatedFilter::class,
];
```

For uniformity, it was replaced by the method:

```php
/ **
 * HTTP data filters
 *
 * @return array
 * /
public function filters (): array
{
    return [
        SearchFilter::class,
        StatusFilter::class,
        CreatedFilter::class,
    ];
}
```




## Remote Functions

### Fields
We removed a few practical possibilities that were previously declared obsolete:
- The field `robot`
- Widget for Google Analytics

A more functional alternative to the `robot` field:

```php
Field::tag ('select')
    ->options ([
        'index' => 'Index',
        'noindex' => 'No index',
    ])
    ->name ('robot')
    ->title ('Indexing')
    ->help ('Allow search bots to index page'),
```
