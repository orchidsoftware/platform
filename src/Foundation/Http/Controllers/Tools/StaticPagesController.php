<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Config;
use Illuminate\Http\Request;
use Orchid\Foundation\Http\Controllers\Controller;
use SEO;

class StaticPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('json', false)) {
            $staticRoute = [];
            foreach (SEO::staticGetRoute() as $value) {
                $base64 = base64_encode($value);
                $staticRoute[$base64] = $value;
            }

            return response()->json([
                'routes' => $staticRoute,
                'baseUrl' => Config::get('app.url'),
            ]);
        } else {
            return view('dashboard::container.tools.static');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $url
     *
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $url = base64_decode($url);
        $meta = SEO::where('route', $url)->first();

        return response()->json($meta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $url
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $url)
    {
        $url = base64_decode($url);
        $meta = SEO::where('route', $url)->first();

        if (is_null($meta)) {
            $attr = $request->all();
            $attr['route'] = $url;
            $attr['url'] = $url;
            SEO::create($attr);
        } else {
            $attr = $request->all();
            $meta->fill($attr)->save();
        }
    }
}
