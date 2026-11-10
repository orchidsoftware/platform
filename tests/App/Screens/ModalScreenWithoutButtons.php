<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Screen;

class ModalScreenWithoutButtons extends Screen
{
    public const TITLE_MODAL = 'Title Modal';
    public const APPLY_BUTTON = 'Test Apply Button';
    public const CLOSE_BUTTON = 'Test Close Button';

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
        return 'Test Screen Modals';
    }

    /**
     * Display header name.
     */
    public function description(): ?string
    {
        return 'Sample Screen Modals';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('exampleModalsWithoutButtons')
                ->name('exampleModalsWithoutButtons')
                ->modal('exampleOneModalWithoutButtons'),
        ];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Modal::make('exampleOneModalWithoutButtons', [
                Rows::make([]),
            ])
                ->title(self::TITLE_MODAL)
                ->size(Modal::SIZE_LG)
                ->applyButton(self::APPLY_BUTTON)
                ->closeButton(self::CLOSE_BUTTON)
                ->withoutApplyButton()
                ->withoutCloseButton(),
        ];
    }
}
