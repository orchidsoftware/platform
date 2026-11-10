<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Screen;
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
     * @return Action[]
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
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Modal::make('validationModal', [
                Rows::make([
                    Input::make('message')
                        ->title('Messages to display')
                        ->placeholder('Hello world!')
                        ->required(),
                ]),
            ])->title('Validation modal message'),
        ];
    }

    public function showMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|min:10',
        ]);

        Toast::warning($request->input('message'));

        return back();
    }
}
