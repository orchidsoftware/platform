<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Press\Models\Menu;
use Orchid\Platform\Dashboard;
use Illuminate\Contracts\View\View;
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
        $this->checkPermission('platform.systems.menu');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function index()
    {
        $availableMenus = collect(config('press.menu'));

        if ($availableMenus->count() > 0) {
            return redirect()->route('platform.systems.menu.show', $availableMenus->keys()->first());
        }

        return abort(404);
    }

    /**
     * @param         $name
     * @param Request $request
     *
     * @return View
     */
    public function show($name, Request $request)
    {
        $availableMenus = config('press.menu');
        $currentLocale = $request->get('lang', app()->getLocale());

        $menu = Dashboard::model(Menu::class)::where('lang', $currentLocale)
            ->where('parent', 0)
            ->where('type', $name)
            ->orderBy('sort', 'asc')
            ->with('children')
            ->get();

        return view('platform::container.systems.menu.menu', [
            'name'           => $name,
            'locales'        => config('press.locales'),
            'currentLocale'  => $currentLocale,
            'menu'           => $menu,
            'availableMenus' => $availableMenus,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->lang = $request->get('lang');
        $this->menu = $request->get('menu');
        $data = json_decode($request->get('data'), true);

        $menu = Dashboard::model(Menu::class)::create(array_merge($data, [
            'lang'   => $this->lang,
            'type'   => $this->menu,
            'parent' => 0,
        ]));

        return response()->json([
            'type' => 'success',
            'id' => $menu->id,
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
     * @param array $items
     * @param int   $parent
     */
    private function createMenuElement(array $items, $parent = 0)
    {
        foreach ($items as $item) {
            Dashboard::model(Menu::class)::firstOrNew([
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
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Menu $menu)
    {
        Dashboard::model(Menu::class)::where('parent', $menu->id)->delete();
        $menu->delete();

        return response()->json([
            'type'    => 'success',
        ]);
    }
}
