<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Orchid\Foundation\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * НАДО ПЕРЕПИСАТЬ!!!
     * По человечески, а то это полная хуйня.
     * @return mixed
     */
    public function upload()
    {
        $input = Input::all();
        $rules = [
            'file' => 'image|max:3000',
        ];

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

        $file = Input::file('file');

        $extension = File::extension($file['name']);
        $directory = path('public') . 'uploads/' . sha1(time());
        $filename = sha1(time() . time()) . ".{$extension}";

        $upload_success = Input::upload('file', $directory, $filename);

        if ($upload_success) {
            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
    }
}
