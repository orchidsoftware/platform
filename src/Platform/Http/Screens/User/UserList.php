<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\User;

use Orchid\Screen\Link;
use App\Layouts\TestRow;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Orchid\Platform\Models\User;
use Orchid\Platform\Http\Layouts\User\UserListLayout;

class UserList extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/users.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/users.description';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
        return  [
            'users' => User::filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [
            Link::name(trans('platform::common.commands.add'))
                ->icon('icon-plus')
                ->method('create'),
            Link::name('Edit password')
                ->modal('oneSynhModal')
                ->title('Change password')
                ->method('changePassword'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout() : array
    {
        return [
/*
            Layouts::modals([
                'oneSynhModal' => [
                    TestRow::class
                ]
            ]),
*/
            Layouts::modals([
               'oneAsyncModal' => [
                   TestRow::class,
               ],
            ])->async(function () {
                return $this->getUser();
            }),

            UserListLayout::class,
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('platform.systems.users.create');
    }

    private function getUser()
    {
        return [
            'id' => '1',
        ];
    }
}
