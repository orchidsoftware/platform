<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Orchid\Platform\Attachments\File;
use Orchid\Platform\Core\Models\Post;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Core\Models\Attachment;
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
            $storage = $request->get('storage', 'public');
            $attachment[] = app()->make(File::class, [
                'file' => $file,
                'storage' => Storage::disk($storage),
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
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy($id, Request $request)
    {
        $storage = $request->get('storage', 'public');
        Attachment::find($id)->delete($storage);

        return response(200);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilesPost($id)
    {
        $files = Post::find($id)->attachment()->oldest('sort')->get();

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
