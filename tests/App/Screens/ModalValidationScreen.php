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
     * Query data.
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Modal Validation';
    }

    /**
     * Display header name.
     */
    public function description(): ?string
    {
        return 'Test screen';
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
                ->method('showMessage'),
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

    public function showMessage(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|min:10',
        ]);

        Toast::warning($request->get('message'));

        return back();
    }
}
