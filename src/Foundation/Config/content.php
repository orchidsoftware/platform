<?php


return [

    /*
     * Types - an abstract pattern of behavior record
     */
    'types' => [
        \Orchid\Foundation\Types\TestType::class,

        \Orchid\Foundation\Types\NewsType::class,
        \Orchid\Foundation\Types\ExhibitionsType::class,
        \Orchid\Foundation\Types\HolidaysType::class,
        \Orchid\Foundation\Types\ChildrenType::class,
        \Orchid\Foundation\Types\CinemaType::class,
        \Orchid\Foundation\Types\ConcertsType::class,
        \Orchid\Foundation\Types\EventType::class,
        \Orchid\Foundation\Types\FestivalsType::class,
        \Orchid\Foundation\Types\TheatricalType::class,
        \Orchid\Foundation\Types\TradeType::class,
        \Orchid\Foundation\Types\CompetitionType::class,
        \Orchid\Foundation\Types\RecreationType::class,
        \Orchid\Foundation\Types\MonumentsType::class,
        \Orchid\Foundation\Types\ParksType::class,
        \Orchid\Foundation\Types\ShrinesType::class,
        \Orchid\Foundation\Types\MuseumsType::class,
        \Orchid\Foundation\Types\CenterType::class,
        \Orchid\Foundation\Types\HotelsType::class,
        \Orchid\Foundation\Types\RestaurantsType::class,
        \Orchid\Foundation\Types\PeopleType::class,

    ],

    /*
     * Available fields to form templates
     */
    'fields' => [
        'textarea' => \Orchid\Foundation\Fields\TextAreaField::class,
        'input' => \Orchid\Foundation\Fields\InputField::class,
        'tags' => \Orchid\Foundation\Fields\TagsField::class,
        'robot' => \Orchid\Foundation\Fields\RobotField::class,
        'place' => \Orchid\Foundation\Fields\PlaceField::class,
        'datetime' => \Orchid\Foundation\Fields\DateTimerField::class,
        'checkbox' => \Orchid\Foundation\Fields\CheckBoxField::class,
    ],

    /*
     *  Available locales
     */
    'locales' => [

        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'dir' => 'ltr',
            'native' => 'English',
            'regional' => 'en_GB',
        ],

        'ru' => [
            'name' => 'Russian',
            'script' => 'Cyrl',
            'dir' => 'ltr',
            'native' => 'Русский',
            'regional' => 'ru_RU',
        ],
    ],

];
