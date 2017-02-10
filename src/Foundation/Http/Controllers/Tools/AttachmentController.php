<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Orchid\Foundation\Core\Models\Attachment;
use Orchid\Foundation\Http\Controllers\Controller;

class AttachmentController extends Controller
{
    /**
     * @var int
     */
    public $time;

    /**
     * @var false|string
     */
    public $date;

    /**
     * AttachmentController constructor.
     */
    public function __construct()
    {
        $this->time = time();
        $this->date = date('Y/m/d');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        try {
            // this is an image
            if (substr($request->file('files')->getMimeType(), 0, 5) == 'image') {
                $file = $this->saveImage($request->file('files'));
            } else {
                $file = $this->saveFile($request->file('files'));
            }
        } catch (\Exception $exception) {
            $file = $this->saveFile($request->file('files'));
        }

        return response()->json($file);
    }

    /**
     * @param UploadedFile $image
     *
     * @return static
     */
    protected function saveImage(UploadedFile $image)
    {
        Storage::disk('public')->makeDirectory($this->date);

        foreach (config('content.images', []) as $key => $value) {
            $this->saveImageProcessing(
                $image,
                $key,
                $value['width'],
                $value['height'],
                $value['quality']
            );
        }

        $name = sha1($this->time.$image->getClientOriginalName());
        $path = '/'.$this->date.'/';

        $full_path = storage_path('app/public/'.'/'.$this->date.'/'.$name.'.'.$image->getClientOriginalExtension());
        Image::make($image)->save($full_path, 100);

        return Attachment::create([
            'name'          => $name,
            'original_name' => $image->getClientOriginalName(),
            'mime'          => $image->getMimeType(),
            'extension'     => $image->getClientOriginalExtension(),
            'size'          => $image->getClientSize(),
            'path'          => $path,
            'user_id'       => Auth::user()->id,
        ]);
    }

    /**
     * @param UploadedFile $file
     *
     * @return UploadedFile|static
     */
    protected function saveFile(UploadedFile $file)
    {
        Storage::disk('public')->makeDirectory($this->date);

        $hashName = sha1($this->time.$file->getClientOriginalName());
        $name = $hashName.'.'.$file->getClientOriginalExtension();
        $path = '/'.$this->date.'/';

        $full_path = storage_path('app/public/'.'/'.$this->date.'/');

        $file->move($full_path, $name);

        try {
            $mimeType = $file->getMimeType();
        } catch (\Exception $exception) {
            $mimeType = 'unknown';
        }

        return Attachment::create([
            'name'          => $hashName,
            'original_name' => $file->getClientOriginalName(),
            'mime'          => $mimeType,
            'extension'     => $file->getClientOriginalExtension(),
            'size'          => $file->getClientSize(),
            'path'          => $path,
            'user_id'       => Auth::user()->id,
        ]);
    }

    /**
     * Delete files.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id)
    {
        $file = Attachment::find($id);
        Storage::disk('public')->delete($file->path.$file->name);
        $file->delete();

        return response(200);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilesPost($id)
    {
        $files = Attachment::where('post_id', $id)->get();

        return response()->json($files);
    }

    /**
     * @param UploadedFile $image
     * @param null         $name
     * @param null         $width
     * @param null         $height
     * @param int          $quality
     *
     * @return static
     */
    protected function saveImageProcessing(
        UploadedFile $image,
        $name = null,
        $width = null,
        $height = null,
        $quality = 100
    ) {
        if (!is_null($name)) {
            $name = '_'.$name;
        }

        $name = sha1($this->time.$image->getClientOriginalName()).$name.'.'.$image->getClientOriginalExtension();
        $full_path = storage_path('app/public/'.'/'.$this->date.'/'.$name);
        Image::make($image)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($full_path, $quality);
    }
}
