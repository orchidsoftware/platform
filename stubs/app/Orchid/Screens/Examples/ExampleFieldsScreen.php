<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\ExampleElements;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ExampleFieldsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Form Controls';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive guide to basic form controls, including input fields, buttons, checkboxes, and radio buttons.';
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
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            ExampleElements::class,
            Layout::rows([
                Group::make([
                    Input::make('name')
                        ->title('Name')
                        ->value('John Doe')
                        ->placeholder('Enter your name')
                        ->help('Enter your full name.')
                        ->horizontal(),

                    Input::make('search_query')
                        ->type('search')
                        ->title('Search Query')
                        ->value('How do I shoot web')
                        ->placeholder('Search...')
                        ->help('Enter your search query.')
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('email')
                        ->type('email')
                        ->title('Email')
                        ->value('bootstrap@example.com')
                        ->placeholder('example@example.com')
                        ->help('Enter your email address.')
                        ->horizontal(),

                    Input::make('website')
                        ->type('url')
                        ->title('Website')
                        ->value('https://orchid.software')
                        ->placeholder('https://example.com')
                        ->help('Enter your website URL.')
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('phone')
                        ->type('tel')
                        ->title('Phone')
                        ->value('1-(555)-555-5555')
                        ->placeholder('Enter phone number')
                        ->horizontal()
                        ->popover('The device’s autocomplete mechanisms kick in and suggest
                        phone numbers that can be autofilled with a single tap.')
                        ->help('Enter your phone number.'),

                    Input::make('password')
                        ->type('password')
                        ->title('Password')
                        ->value('Password')
                        ->placeholder('Enter password')
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('quantity')
                        ->type('number')
                        ->title('Quantity')
                        ->value(42)
                        ->placeholder('Enter quantity')
                        ->horizontal(),

                    Input::make('appointment_datetime')
                        ->type('datetime-local')
                        ->title('Appointment Date and Time')
                        ->value('2011-08-19T13:45:00')
                        ->placeholder('YYYY-MM-DDTHH:MM')
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('event_date')
                        ->type('date')
                        ->title('Event Date')
                        ->value('2011-08-19')
                        ->placeholder('YYYY-MM-DD')
                        ->horizontal(),

                    Input::make('event_month')
                        ->type('month')
                        ->title('Event Month')
                        ->value('2011-08')
                        ->placeholder('YYYY-MM')
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('week_number')
                        ->type('week')
                        ->title('Week Number')
                        ->value('2011-W33')
                        ->placeholder('YYYY-W##')
                        ->horizontal(),

                    Input::make('event_time')
                        ->type('time')
                        ->title('Event Time')
                        ->value('13:45:00')
                        ->placeholder('HH:MM:SS')
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('city')
                        ->title('City')
                        ->help('Select a city from the list.')
                        ->datalist([
                            'San Francisco',
                            'New York',
                            'Seattle',
                            'Los Angeles',
                            'Chicago',
                        ])
                        ->horizontal(),

                    Input::make('color_picker')
                        ->type('color')
                        ->title('Color Picker')
                        ->value('#563d7c')
                        ->horizontal(),
                ]),

                Button::make('Submit')
                    ->method('buttonClickProcessing')
                    ->type(Color::BASIC),
            ]),

            Layout::columns([
                Layout::rows([

                    Input::make('name')
                        ->title('Full Name:')
                        ->placeholder('Enter full name')
                        ->required()
                        ->help('Please enter your full name'),

                    Input::make('email')
                        ->title('Email address')
                        ->placeholder('Email address')
                        ->help("We'll never share your email with anyone else.")
                        ->popover('Tooltip - hint that user opens himself.'),

                    Password::make('password')
                        ->title('Password')
                        ->placeholder('Password'),

                    Label::make('static')
                        ->title('Static:')
                        ->value('email@example.com'),

                    Select::make('select')
                        ->title('Select')
                        ->options([1, 2]),

                    CheckBox::make('checkbox')
                        ->title('Checkbox')
                        ->placeholder('Remember me'),

                    Group::make([
                        Radio::make('radio')
                            ->placeholder('Yes')
                            ->value(1)
                            ->title('Radio'),

                        Radio::make('radio')
                            ->placeholder('No')
                            ->value(0),
                    ])
                        ->autoWidth()
                        ->alignEnd(),

                    TextArea::make('textarea')
                        ->title('Example textarea')
                        ->rows(6),

                ])->title('Base Controls'),
                Layout::rows([
                    Input::make('disabled_input')
                        ->title('Disabled Input')
                        ->placeholder('Disabled Input')
                        ->help('A disabled input element is unusable and un-clickable.')
                        ->disabled(),

                    Select::make('disabled_select')
                        ->title('Disabled select')
                        ->options([1, 2])
                        ->value(0)
                        ->disabled(),

                    TextArea::make('disabled_textarea')
                        ->title('Disabled textarea')
                        ->placeholder('Disabled textarea')
                        ->rows(6)
                        ->disabled(),

                    Input::make('readonly_input')
                        ->title('Readonly Input')
                        ->placeholder('Readonly Input')
                        ->readonly(),

                    CheckBox::make('readonly_checkbox')
                        ->title('Readonly Checkbox')
                        ->placeholder('Remember me')
                        ->disabled(),

                    Group::make([
                        Radio::make('radio')
                            ->placeholder('Yes')
                            ->value(1)
                            ->title('Radio')
                            ->disabled(),

                        Radio::make('radio')
                            ->placeholder('No')
                            ->value(0)
                            ->disabled(),
                    ])
                        ->autoWidth()
                        ->alignEnd(),

                    TextArea::make('readonly_textarea')
                        ->title('Readonlyd textarea')
                        ->placeholder('Readonlyd textarea')
                        ->rows(7)
                        ->disabled(),

                ])->title('Input States'),
            ]),
        ];
    }

    public function buttonClickProcessing()
    {
        Alert::warning('Provide contextual feedback messages for typical user actions with the handful of available and flexible alert messages.');
    }
}
