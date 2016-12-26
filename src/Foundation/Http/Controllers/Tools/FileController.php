<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Orchid\Foundation\Core\Models\File;
use Orchid\Foundation\Http\Controllers\Controller;

class FileController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('images')) {
            $file = $this->saveImage($request->file('images'));

            return response()->json($file);
        } elseif ($request->hasFile('files')) {
            $file = $this->saveFile($request->file('files'));

            return response()->json($file);
        } else {
            abort(415);
        }
    }

    /**
     * @param UploadedFile $image
     * @return static
     */
    protected function saveImage(UploadedFile $image)
    {
        Storage::disk('public')->makeDirectory(date('Y/m/d'));

        $name = sha1(time().$image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
        $path = '/'.date('Y/m/d').'/';

        $full_path = storage_path('app/public/'.'/'.date('Y/m/d').'/'.$name);
        Image::make($image)->save($full_path, 75);

        $file = File::create([
            'name' => $name,
            'original_name' => $image->getClientOriginalName(),
            'mime' => $image->getMimeType(),
            'path' => $path,
            'user_id' => Auth::user()->id,
        ]);

        return $file;
    }


    /**
     * @param UploadedFile $file
     * @return UploadedFile|static
     */
    protected function saveFile(UploadedFile $file)
    {
        Storage::disk('public')->makeDirectory(date('Y/m/d'));

        $name = sha1(time().$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
        $path = '/'.date('Y/m/d').'/';

        $full_path = storage_path('app/public/'.'/'.date('Y/m/d').'/'.$name);

        $file->move($full_path, $name);

        $file = File::create([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
            'path' => $path,
            'user_id' => Auth::user()->id,
        ]);

        return $file;
    }

    /**
     * Delete files.
     */
    public function destroy($id)
    {
        $file = File::find($id);
        Storage::disk('public')->delete($file->path.$file->name);
        $file->delete();

        return response(200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilesPost($id)
    {
        $files = File::where('post_id', $id)->get();

        return response()->json($files);
    }

    protected function saveImageDataBase()
    {
    }
}
