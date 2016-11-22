<?php

namespace Orchid\Foundation\Http\Controllers\Posts;

use Orchid\Foundation\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index($type = null)
    {
        dd($type, 'controller');
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
