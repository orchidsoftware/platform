<?php

namespace Orchid\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use Orchid\Alert\Facades\Alert;
use Orchid\Core\Models\Post;
use Orchid\Http\Controllers\Controller;
use Orchid\Http\Forms\Marketing\Advertising\AdvertisingFormGroup;

class AdvertisingController extends Controller
{
    /**
     * @var AdvertisingFormGroup
     */
    public $form;

    /**
     * AdvertisingController constructor.
     *
     * @param AdvertisingFormGroup $form
     */
    public function __construct(AdvertisingFormGroup $form)
    {
        $this->checkPermission('dashboard.marketing.advertising');
        $this->form = $form;
    }

    /**
     * @return string
     */
    public function index()
    {
        return $this->form->grid();
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return $this->form
            ->route('dashboard.marketing.advertising.store')
            ->method('POST')
            ->render();
    }

    /**
     * @param Request   $request
     * @param Post|null $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Post $post = null)
    {
        $this->form->save($request, $post);

        Alert::success(trans('dashboard::common.alert.success'));

        return back();
    }

    /**
     * @param Post $post
     *
     * @return mixed
     */
    public function edit(Post $post)
    {
        return $this->form
            ->route('dashboard.marketing.advertising.update')
            ->slug($post->id)
            ->method('PUT')
            ->render($post);
    }

    /**
     * @param Request $request
     * @param Post    $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $user)
    {
        $this->form->save($request, $user);

        Alert::success(trans('dashboard::common.alert.success'));

        return back();
    }

    /**
     * @param Post $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $user)
    {
        $this->form->remove($user);

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.marketing.users');
    }
}
