<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ModalValidationScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Modal Validation';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Test screen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('Show modal')
                ->modal('validationModal')
                ->method('showMessage')
                ->icon('icon-full-screen'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::modal('validationModal', [
                Layout::rows([
                    Input::make('message')
                        ->title('Messages to display')
                        ->placeholder('Hello world!')
                        ->required(),
                ]),
            ])->title('Validation modal message'),
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showMessage(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|min:10',
        ]);

        Toast::warning($request->get('message'));

        return back();
    }
}
