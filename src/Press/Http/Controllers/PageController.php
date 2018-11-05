<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Press\Models\Page;
use Orchid\Support\Facades\Alert;

class PageController extends Controller
{
    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function show(Page $page = null)
    {
        $this->checkPermission('platform.posts.type.' . $page->slug);
        $type = $page->getEntityObject($page->slug);

        return view('platform::container.posts.page', [
            'type' => $type,
            'locales' => collect($type->locale()),
            'post' => $type->create($page),
        ]);
    }

    /**
     * @param Page $page
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function update(Page $page, Request $request)
    {
        $this->checkPermission('platform.posts.type.' . $page->slug);
        $type = $page->getEntityObject($page->slug);
        $type->isValid();

        $page
            ->fill($request->all())
            ->fill([
                'user_id' => $request->user()->id,
                'type' => 'page',
                'slug' => $page->slug,
                'status' => 'publish',
                'options' => $page->getOptions(),
                'publish_at' => Carbon::now(),
            ]);

        $type->save($page);

        Alert::success(__('Operation completed successfully.'));

        return back();
    }
}
