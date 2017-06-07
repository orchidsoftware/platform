<?php

namespace Orchid\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Orchid\Core\Models\Attachment;
use Orchid\Http\Controllers\Controller;

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
        $this->checkPermission('dashboard.tools.attachment');
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

        $name = sha1($this->time . $image->getClientOriginalName());

        $fullPath = storage_path('app/public/' . DIRECTORY_SEPARATOR . $this->date . DIRECTORY_SEPARATOR . $name . '.' . $image->getClientOriginalExtension());
        Image::make($image)->save($fullPath, 100);

        return Attachment::create([
            'name'          => $name,
            'original_name' => $image->getClientOriginalName(),
            'mime'          => $image->getMimeType(),
            'extension'     => $image->getClientOriginalExtension(),
            'size'          => $image->getClientSize(),
            'path'          => $this->date . DIRECTORY_SEPARATOR,
            'user_id'       => Auth::user()->id,
        ]);
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
            $name = '_' . $name;
        }

        $name = sha1($this->time . $image->getClientOriginalName()) . $name . '.' . $image->getClientOriginalExtension();
        $fullPath = storage_path('app/public/' . DIRECTORY_SEPARATOR . $this->date . DIRECTORY_SEPARATOR . $name);
        Image::make($image)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($fullPath, $quality);
    }

    /**
     * @param UploadedFile $file
     *
     * @return UploadedFile|static
     */
    protected function saveFile(UploadedFile $file)
    {
        Storage::disk('public')->makeDirectory($this->date);

        $hashName = sha1($this->time . $file->getClientOriginalName());
        $name = $hashName . '.' . $file->getClientOriginalExtension();

        $fullPath = storage_path('app/public/' . DIRECTORY_SEPARATOR . $this->date . DIRECTORY_SEPARATOR);

        $file->move($fullPath, $name);

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
            'path'          => $this->date . DIRECTORY_SEPARATOR,
            'user_id'       => Auth::user()->id,
        ]);
    }

    /**
     * @param Request $request
     */
    public function sort(Request $request)
    {
        $files = $request->get('files', []);
        foreach ($files as $id => $sort) {
            $attachment = Attachment::find($id);
            $attachment->sort = $sort;
            $attachment->save();
        }
    }

    /**
     * Delete files.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy($id)
    {
        Attachment::find($id)->delete();

        return response(200);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilesPost($id)
    {
        $files = Attachment::where('post_id', $id)->orderBy('sort', 'asc')->get();

        return response()->json($files);
    }

    /**
     * @param         $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update($id, Request $request)
    {
        $files = Attachment::findOrFail($id);
        $files->fill($request->get('attachment', []));
        $files->save();

        return response(200);
    }
}
