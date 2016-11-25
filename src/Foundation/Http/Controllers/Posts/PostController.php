<?php

namespace Orchid\Foundation\Http\Controllers\Posts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Http\Controllers\Controller;

class PostController extends Controller
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
        $this->locales = config('content.locales');
    }


    public function index($type = null)
    {
        $name = $type->getTypeObject()->name;

        return view('dashboard::container.posts.main', [
            'name' => $name,
        ]);
    }

    /**
     * @param null $type
     */
    public function create($type)
    {
        $type = $type->getTypeObject();

        return view('dashboard::container.posts.create', [
            'type' => $type,
            'locales' => $this->locales,
        ]);
    }

    public function show($test = null, $test2 = null)
    {
        dd($test, $test2);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request, Post $post)
    {
        //$this->validate($request, $post->getTypeObject()->rules());

        $post->fill($request->all());
        $post->type = $post->getTypeObject()->slug;
        $post->user_id = Auth::user()->id;
        $post->slug = Str::slug($request->get('content')[config('app.locale')][$post->getTypeObject()->slugFields]);
        $post->page = $post->getTypeObject()->page;
        $post->save();



        Alert::success('Message');

        return redirect()->route('dashboard.posts.type',[
            'type' => $post->type,
            'slug' => $post->slug,
        ]);

    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
