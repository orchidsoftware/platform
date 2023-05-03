<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ItemAddChildScreen extends Screen
{
    public $parent_id;
    public $item;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param int $parent_id
     *
     * @return array
     */
    public function query(int $parentId): iterable
    {
        return [
            'parent_id' => $parentId,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Add child';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return '';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Button::make(__('Save'))
                ->icon('check')
                ->method('addChild'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::rows([
                Input::make('item.name')
                    ->title('Name')
                    ->required()
                    ->placeholder('Enter task name')
                    ->help('The name of the task to be created.'),

            ]),

        ];
    }

    public function addChild(Request $request, int $parentId)
    {
        // Validate form data, save task to database, etc.

        $request->validate([
            'item.name' => 'required|max:255',
        ]);

        Toast::info('Item with paretn_id=' . $parentId . ' saved');

        return redirect()->route('test.items');
    }
}
