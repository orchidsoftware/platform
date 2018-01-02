<?php

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Attachments\File;
use Orchid\Platform\Core\Models\Attachment;
use Orchid\Platform\Core\Models\Post;
use Orchid\Platform\Http\Controllers\Controller;

class AttachmentController extends Controller
{
    /**
     * AttachmentController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.systems.attachment');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $attachment = [];
        foreach ($request->allFiles() as $file) {
            $storage = $request->input('storage') ?: 'public';
            $attachment[] = app()->make(File::class, [
                'file' => $file,
                'storage' => Storage::disk($storage)
            ])->load();
        }

        if (count($attachment) > 1) {
            return response()->json($attachment);
        }

        return response()->json(reset($attachment));
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
        $files = Post::find($id)->attachment()->orderBy('sort', 'asc')->get();

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
