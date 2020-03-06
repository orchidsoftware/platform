<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;

class ModalScreen extends Screen
{
    public const TITLE_MODAL = 'Title Modal';
    public const APPLY_BUTTON = 'Test Apply Button';
    public const CLOSE_BUTTON = 'Test Close Button';

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Test Screen Modals';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Sample Screen Modals';

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
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make('exampleModals')
                ->name('exampleModals'),
        ];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::modal('exampleOneModal', [
                Layout::rows([]),
            ])
                ->title(self::TITLE_MODAL)
                ->size(Modal::SIZE_LG)
                ->applyButton(self::APPLY_BUTTON)
                ->closeButton(self::CLOSE_BUTTON),
        ];
    }
}
