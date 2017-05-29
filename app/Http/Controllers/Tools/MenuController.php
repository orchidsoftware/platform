<?php

namespace Orchid\Http\Controllers\Tools;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Core\Models\Menu;
use Orchid\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * @var
     */
    public $lang;

    /**
     * @var
     */
    public $menu;

    /**
     * @return View
     */
    public function index()
    {
        $this->checkPermission('dashboard.tools.menu');

        return view('dashboard::container.tools.menu.listing', [
            'menu'    => collect(config('content.menu')),
            'locales' => collect(config('content.locales')),
        ]);
    }

    /**
     * @param         $nameMenu
     * @param Request $request
     *
     * @return View
     */
    public function show($nameMenu, Request $request)
    {
        $currentLocale = $request->get('lang', App::getLocale());

        $menu = Menu::where('lang', $currentLocale)
            ->whereNull('parent')
            ->where('type', $nameMenu)->with('children')->get();

        return view('dashboard::container.tools.menu.menu', [
            'nameMenu'      => $nameMenu,
            'locales'       => config('content.locales'),
            'currentLocale' => $currentLocale,
            'menu'          => $menu,
            'staticPage'    => [],
            'url'           => config('app.url'),
        ]);
    }

    /**
     * @param         $menu
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($menu, Request $request)
    {
        $this->lang = $request->get('lang');
        $this->menu = $menu;

        Menu::where('lang', $this->lang)
            ->where('type', $menu)
            ->delete();

        $this->createMenuElement($request->get('data'));

        return response()->json([
            'title'   => 'Успешно',
            'message' => 'Данные сохранены',
            'type'    => 'success',
        ]);
    }

    /**
     * @param array $items
     * @param null  $parent
     */
    private function createMenuElement(array $items, $parent = null)
    {
        foreach ($items as $item) {
            unset($item['id']);
            $item['lang'] = $this->lang;
            $item['type'] = $this->menu;
            $item['parent'] = $parent;
            $menu = Menu::create($item);

            if (array_key_exists('children', $item)) {
                $this->createMenuElement($item['children'], $menu->id);
            }
        }
    }
}
