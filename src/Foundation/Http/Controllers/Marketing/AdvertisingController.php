<?php
namespace Orchid\Foundation\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Marketing\Advertising\AdvertisingFormGroup;

class AdvertisingController extends Controller
{
    /**
     * @var
     */
    public $form = AdvertisingFormGroup::class;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.marketing.advertising');
        $this->form = new $this->form();
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
     * @param Request $request
     * @param Post|null $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Post $post = null)
    {
        $this->form->save($request, $post);

        return redirect()->back();
    }


    /**
     * @param Post $post
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
     * @param Post $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $user)
    {
        $this->form->save($request, $user);

        return redirect()->back();
    }


    /**
     * @param Post $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $user)
    {
        $this->form->remove($user);

        return redirect()->route('dashboard.marketing.users');
    }
}
