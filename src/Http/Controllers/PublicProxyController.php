<?php

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Support\Facades\File;
use Mimey\MimeTypes;

class PublicProxyController extends Controller
{
    /**
     * @var MimeTypes
     */
    public $mime;

    /**
     * PublicProxyController constructor.
     */
    public function __construct()
    {
        $this->mime = new MimeTypes();
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    public function index($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $type = $this->mime->getMimeType($extension);

        return response(File::get($path), 200)
            ->header("Cache-Control", " private, max-age=86400")
            ->header('Content-Type', $type);
    }
}
