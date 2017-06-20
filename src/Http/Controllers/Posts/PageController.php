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
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $this->checkPermission('dashboard.pages.' . $slug);
        $page = Page::where('slug', $slug)->first();

        if (is_null($page)) {
            $page = new Page();
        }

        return view('dashboard::container.posts.page', [
            'type'    => $page->getBehaviorObject($slug),
            'locales' => $this->locales->where('required', true),
            'post'    => $page,
        ]);
    }

    /**
     * @param         $slug
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($slug, Request $request)
    {
        $this->checkPermission('dashboard.pages.' . $slug);
        $page = Page::where('slug', $slug)->firstOrFail()->getBehavior($slug);
        $type = $page->getBehaviorObject($slug);


        $page->fill($request->all());

        $page->fill([
            'user_id'    => Auth::user()->id,
            'type'       => 'page',
            'slug'       => $slug,
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
