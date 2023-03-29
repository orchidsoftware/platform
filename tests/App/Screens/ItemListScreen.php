<?php

namespace Orchid\Tests\App\Screens;

use App\Models\Task;
use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ItemListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'items'   => [
                new Repository(['id' => 100, 'name' => 'name1', 'price' => 10.24, 'created_at' => '01.01.2020']),
                new Repository(['id' => 200, 'name' => 'name 2', 'price' => 65.9, 'created_at' => '01.01.2020']),
                new Repository(['id' => 300, 'name' => 'name 3', 'price' => 754.2, 'created_at' => '01.01.2020']),
                new Repository(['id' => 400, 'name' => 'name 4', 'price' => 0.1, 'created_at' => '01.01.2020']),
                new Repository(['id' => 500, 'name' => 'name 5', 'price' => 0.15, 'created_at' => '01.01.2020']),

            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Items List';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return ' ';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Item')
                ->modal('itemModal')
                ->method('create')
                ->icon('plus'),

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('items', [
                TD::make('id'),
                TD::make('name'),
                TD::make('parent_id'),

                TD::make('Actions')
                    ->alignRight()
                    ->render(fn (Repository $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Button::make('Delete Task')
                                ->confirm('After deleting, the task will be gone forever.')
                                ->method('delete', ['item' => $model->get('id')]),
                            Link::make(__('Add child'))
                                ->route('test.item.addchild', $model->get('id'))
                                ->icon('pencil'),
                        ])),
            ]),
            Layout::modal('itemModal', Layout::rows([
                Input::make('item.name')
                    ->title('Name')
                    ->placeholder('Enter item name')
                    ->help('The name of the task to be created.'),

            ]))
                ->title('Create Item')
                ->applyButton('Add Item'),
        ];
    }

    public function create(Request $request)
    {
        // Validate form data, save task to database, etc.

        $request->validate([
            'item.name' => 'required|max:255',
        ]);

        Toast::info(__('Added Item'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function delete(Repository $item)
    {
        Toast::info('Item '.$item->get('id').' deleted');
    }
}
