<?php

namespace Orchid\Tests\Exemplar\App\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts\Modals;

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
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::modal('exampleModals')
                ->title(self::TITLE_MODAL)
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
            Layout::modals([
                'exampleModals' => Layout::rows([]),
            ])
                ->size(Modals::SIZE_LG)
                ->applyButton(self::APPLY_BUTTON)
                ->closeButton(self::CLOSE_BUTTON),
        ];
    }
}
