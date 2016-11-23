<?php

namespace Orchid\Foundation\Http\Controllers\Posts;

use Orchid\Foundation\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index($type = null)
    {
        $name = $type->dataType->name;

        return view('dashboard::container.posts.main',[
            'name' => $name
        ]);
    }

    /**
     * @param null $type
     */
    public function create($type){
        $type = $type->dataType;
        return view('dashboard::container.posts.create',[
            'type' => $type
        ]);
    }



    public function show($test = null, $test2 = null)
    {
        dd($test, $test2);
    }

    public function store()
    {
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
