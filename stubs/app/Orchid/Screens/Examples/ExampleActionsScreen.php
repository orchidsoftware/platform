<?php

namespace App\Orchid\Screens\Examples;

use App\Orchid\Layouts\Examples\ExampleElements;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ExampleActionsScreen extends Screen
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
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Actions Form Controls';
    }

    /**
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Examples for creating a wide variety of forms.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ExampleElements::class,
            Layout::rows([
                Group::make([
                    Button::make('Primary')->method('buttonClickProcessing')->type(Color::PRIMARY),
                    Button::make('Secondary')->method('buttonClickProcessing')->type(Color::SECONDARY),
                    Button::make('Success')->method('buttonClickProcessing')->type(Color::SUCCESS),
                    Button::make('Danger')->method('buttonClickProcessing')->type(Color::DANGER),
                    Button::make('Warning')->method('buttonClickProcessing')->type(Color::WARNING),
                    Button::make('Info')->method('buttonClickProcessing')->type(Color::INFO),
                    Button::make('Light')->method('buttonClickProcessing')->type(Color::LIGHT),
                    Button::make('Dark')->method('buttonClickProcessing')->type(Color::DARK),
                    Button::make('Default')->method('buttonClickProcessing')->type(Color::BASIC),
                    Button::make('Link')->method('buttonClickProcessing')->type(Color::LINK),
                ])->autoWidth(),

                Group::make([
                    Link::make('Basic Link')->href('#'),
                    Link::make('Open new window')->href('#')->target('_blank'),
                    Link::make('Download File')->href('#')->download(),
                ])->autoWidth(),
            ]),

            Layout::block(Layout::rows([
                Group::make([
                    DropDown::make('Dropdown for Buttons')
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Button::make('Action')->method('buttonClickProcessing'),
                            Button::make('Another action')->method('buttonClickProcessing'),
                            Button::make('Something else here')->method('buttonClickProcessing'),
                        ]),

                    DropDown::make('Dropdown for Links')
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make('Action')->href('#'),
                            Link::make('Another action')->href('#'),
                            Link::make('Something else here')->href('#'),
                        ]),
                ])->autoWidth(),
            ]))
                ->title('Dropdowns')
                ->description('Contextual overlays for displaying lists of links and buttons'),

            Layout::block(Layout::rows([
                Group::make([
                    Button::make('Submit')->type(Color::PRIMARY)->disabled(),
                    Button::make('Submit')->disabled(),
                ])->autoWidth(),
            ]))
                ->title('Disabled state')
                ->description('A disabled button is unusable and un-clickable.'),

            Layout::block(Layout::rows([
                Button::make('Submit')
                    ->method('buttonClickProcessing')
                    ->confirm('Communicating the consequences of the decision.'),
            ]))
                ->title('Confirm Dialog')
                ->description('Confirm Dialog is a modal Dialog used to confirm user actions.'),

            Layout::block(Layout::rows([
                Button::make('Button')
                    ->icon('bs.box-arrow-up-right')
                    ->method('buttonClickProcessing'),
            ]))
                ->title('Icons Button')
                ->description('This type of button is often used to save space on a user interface and make the action more visually appealing.'),

            Layout::block(Layout::rows([
                Button::make('Download')
                    ->icon('bs.download')
                    ->method('export')
                    ->rawClick(),
            ]))
                ->title('Download Button')
                ->description('This button is typically used when a user wants to download a file, such as a document or an image, to their local device.'),

            Layout::block(Layout::rows([
                Button::make('Google')
                    ->action('https://google.com'),
            ]))
                ->title('Custom Route')
                ->description('The form is always sent by POST request, but the endpoint can be defined'),

        ];
    }

    /**
     * @return void
     */
    public function buttonClickProcessing(): void
    {
        Toast::warning('Click Processing');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        return response()->streamDownload(function () {
            $csv = tap(fopen('php://output', 'wb'), function ($csv) {
                fputcsv($csv, ['header:col1', 'header:col2', 'header:col3']);
            });

            collect([
                ['row1:col1', 'row1:col2', 'row1:col3'],
                ['row2:col1', 'row2:col2', 'row2:col3'],
                ['row3:col1', 'row3:col2', 'row3:col3'],
            ])->each(function (array $row) use ($csv) {
                fputcsv($csv, $row);
            });

            return tap($csv, function ($csv) {
                fclose($csv);
            });
        }, 'File-name.csv');
    }
}
