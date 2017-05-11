<?php

namespace Orchid\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Http\Controllers\Controller;

class RobotsController extends Controller
{

    /**
     * @var
     */
    public $storage;

    /**
     * RobotsController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.marketing.robots');
        $this->storage = Storage::disk('public');
    }

    /**
     * @return string
     */
    public function index()
    {
        $content = $this->storage->exists('file.jpg') ? $this->storage->get('robots.txt') : '';

        return view('dashboard::container.marketing.robots.index', [
            'content' => $content,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->storage->put('robots.txt', $request->get('content', ''));

        return redirect()->back();
    }
}
