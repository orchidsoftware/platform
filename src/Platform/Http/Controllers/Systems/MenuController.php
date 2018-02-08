<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Orchid\Platform\Core\Models\Menu;
use Orchid\Platform\Http\Controllers\Controller;

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
     * MenuController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.systems.menu');
    }

    /**
     * @return View
     */
    public function index()
    {
        $menu = collect(config('platform.menu'));

        if ($menu->count() === 1) {
            return redirect()->route('dashboard.systems.menu.show', $menu->keys()->first());
        }

        return view('dashboard::container.systems.menu.listing', [
            'menu' => collect(config('platform.menu')),
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
            ->where('parent', 0)
            ->where('type', $nameMenu)
            ->with('children')
            ->get();

        return view('dashboard::container.systems.menu.menu', [
            'nameMenu'      => $nameMenu,
            'locales'       => config('platform.locales'),
            'currentLocale' => $currentLocale,
            'menu'          => $menu,
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

        $this->createMenuElement($request->get('data'));

        return response()->json([
            'type'    => 'success',
        ]);
    }

    /**
     * @param array   $items
     * @param int $parent
     */
    private function createMenuElement(array $items, $parent = 0)
    {
        foreach ($items as $item) {
            Menu::firstOrNew([
                'id' => $item['id'],
            ])->fill(array_merge($item, [
                'lang'   => $this->lang,
                'type'   => $this->menu,
                'parent' => $parent,
            ]))->save();

            if (array_key_exists('children', $item)) {
                $this->createMenuElement($item['children'], $item['id']);
            }
        }
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        Menu::where('parent', $menu->id)->delete();
        $menu->delete();

        return response()->json([
            'type'    => 'success',
        ]);
    }
}
