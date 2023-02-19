<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\ExampleElements;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
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
        return [
            'name' => 'Hello! We collected all the fields in one place',
        ];
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
                Input::make('test')
                    ->title('Text')
                    ->value('Artisanal kale')
                    ->help('Basic single-line text fields.')
                    ->horizontal(),

                Input::make('search')
                    ->type('search')
                    ->title('Search')
                    ->value('How do I shoot web')
                    ->help('Text fields designed for the user to enter search queries into.')
                    ->horizontal(),

                Input::make('email')
                    ->type('email')
                    ->title('Email')
                    ->value('bootstrap@example.com')
                    ->help('Used to let the user enter and edit an e-mail address')
                    ->horizontal(),

                Input::make('url')
                    ->type('url')
                    ->title('Url')
                    ->value('https://getbootstrap.com')
                    ->horizontal()
                    ->help('You might use this when asking to input their website address for a business directory'),

                Input::make('tel')
                    ->type('tel')
                    ->title('Telephone')
                    ->value('1-(555)-555-5555')
                    ->horizontal()
                    ->popover('The device’s autocomplete mechanisms kick in and suggest
                        phone numbers that can be autofilled with a single tap.')
                    ->help('Focusing input on a telephone field brings up
                        a numeric keypad ready for keying in a number.'),

                Input::make('password')
                    ->type('password')
                    ->title('Password')
                    ->value('Password')
                    ->horizontal(),

                Input::make('number')
                    ->type('number')
                    ->title('Number')
                    ->value(42)
                    ->horizontal(),

                Input::make('date_and_time')
                    ->type('datetime-local')
                    ->title('Date and time')
                    ->value('2011-08-19T13:45:00')
                    ->horizontal(),

                Input::make('date')
                    ->type('date')
                    ->title('Date')
                    ->value('2011-08-19')
                    ->horizontal(),

                Input::make('month')
                    ->type('month')
                    ->title('Month')
                    ->value('2011-08')
                    ->horizontal(),

                Input::make('week')
                    ->type('week')
                    ->title('Week')
                    ->value('2011-W33')
                    ->horizontal(),

                Input::make('Time')
                    ->type('time')
                    ->title('Time')
                    ->value('13:45:00')
                    ->horizontal(),

                Input::make('datalist')
                    ->title('Datalist example')
                    ->help('Most browsers include some support for "datalist"
                                 elements, their styling is inconsistent at best.')
                    ->datalist([
                        'San Francisco',
                        'New York',
                        'Seattle',
                        'Los Angeles',
                        'Chicago',
                    ])
                    ->horizontal(),

                Input::make('color')
                    ->type('color')
                    ->title('Color')
                    ->value('#563d7c')
                    ->horizontal(),

                Button::make('Submit')
                    ->method('buttonClickProcessing')
                    ->type(Color::BASIC),

            ]), //->title('Textual HTML5 Inputs'),

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

                    Radio::make('radio')
                        ->placeholder('Yes')
                        ->value(1)
                        ->title('Radio'),

                    Radio::make('radio')
                        ->placeholder('No')
                        ->value(0),

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

                    Radio::make('radio')
                        ->placeholder('Yes')
                        ->value(1)
                        ->title('Radio')
                        ->disabled(),

                    Radio::make('radio')
                        ->placeholder('No')
                        ->value(0)
                        ->disabled(),

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
