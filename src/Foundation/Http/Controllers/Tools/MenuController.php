<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Orchid\Foundation\Core\Models\Menu;

class MenuController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $menuitems = new Menu();
        $menulist = []; //Menu::lists('name', 'id');
        $menulist[0] = 'Выберите меню';
        if (Input::has('action')) {
            return view('dashboard::container.tools.menu.menu')
                ->with('menulist', $menulist);
        } else {
            $menu = Menu::find(Input::get('menu'));
            $menus = $menuitems->getall(Input::get('menu'));

            return view('dashboard::container.tools.menu.menu', [
                'menus' => $menus,
                'indmenu' => $menu,
                'menulist' => $menulist,
            ]);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function createNewMenu(Request $request)
    {
        $menu = new Menu();
        $menu->name = Input::get('menuname');
        $menu->save();

        return json_encode(['resp' => $menu->id]);
    }

    /**
     * @param Request $request
     */
    public function deleteItemMenu(Request $request)
    {
        $menuitem = MenuElement::find(Input::get('id'));
        $menuitem->delete();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function deleteMenug(Request $request)
    {
        $menus = new MenuElement();
        $getall = $menus->getall(Input::get('id'));
        if (count($getall) == 0) {
            $menudelete = Menu::find(Input::get('id'));
            $menudelete->delete();

            return json_encode(['resp' => 'Вы удалили этот элемент']);
        } else {
            return json_encode(['resp' => 'Вы должны сначала удалить все элементы', 'error' => 1]);
        }
    }

    /**
     * @param Request $request
     */
    public function updateItem(Request $request)
    {/*
        $menuitem = MenuElement::find(Input::get('id'));
        $menuitem->label = Input::get('label');
        $menuitem->link = Input::get('url');
        $menuitem->class = Input::get('clases');
        $menuitem->save();
*/
        $item = MenuElement::find($request->input('id'));
        $item->fill($request->all());
        $item->save();
    }

    /**
     * @param Request $request
     */
    public function addCustomMenu(Request $request)
    {
        // $menuitem = new MenuElement();
        MenuElement::create($request->all());
        // $menuitem->label = Input::get('labelmenu');
        //$menuitem->link = Input::get('linkmenu');
        //$menuitem->menu = Input::get('idmenu');
        //$menuitem->save();
    }

    /**
     * @param Request $request
     */
    public function generateMenuControl(Request $request)
    {
        $menu = Menu::find(Input::get('idmenu'));
        $menu->name = Input::get('menuname');
        $menu->save();
        foreach (Input::get('arraydata') as $value) {
            $menuitem = MenuElement::find($value['id']);
            $menuitem->parent = $value['parent'];
            $menuitem->sort = $value['sort'];
            $menuitem->depth = $value['depth'];
            $menuitem->save();
        }
        echo json_encode(['resp' => 1]);
    }
}
