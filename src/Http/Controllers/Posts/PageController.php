<?php

namespace Orchid\Http\Controllers\Posts;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Alert\Facades\Alert;
use Orchid\Core\Models\Page;
use Orchid\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * @var
     */
    public $locales;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.posts');
        $this->locales = collect(config('content.locales'));
    }

    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Page $page = null)
    {
        $this->checkPermission('dashboard.pages.' . $page->slug);

        $locales = $this->locales->map(function ($value, $key) use ($page) {
            $value['required'] = (bool) $page->checkLanguage($key);

            return $value;
        })->where('required', true);

        return view('dashboard::container.posts.page', [
            'type'    => $page->getBehaviorObject($page->slug),
            'locales' => $locales,
            'post'    => $page,
        ]);
    }

    /**
     * @param         $page
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Page $page, Request $request)
    {
        $this->checkPermission('dashboard.pages.' . $page->slug);
        $type = $page->getBehaviorObject($page->slug);


        $page->fill($request->all());

        $locales = collect(config('content.locales'));
        $locales = $locales->map(function ($item) {
            if ($item['required'] == true) {
                return true;
            }

            return false;
        })->toArray();

        $page->options = [
            'locale' => $request->get('options', $locales),
        ];

        $page->fill([
            'user_id'    => Auth::user()->id,
            'type'       => 'page',
            'slug'       => $page->slug,
            'status'     => 'publish',
            'options'    => $page->getOptions(),
            'publish_at' => Carbon::now(),
        ]);

        $page->save();

        $modules = $type->getModules();

        foreach ($modules as $module) {
            $module = new $module();
            $module->save($type, $page);
        }

        Alert::success(trans('dashboard::common.alert.success'));

        return back();
    }
}
