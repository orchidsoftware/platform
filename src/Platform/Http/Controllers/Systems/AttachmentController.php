<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Illuminate\Support\Arr;
use Orchid\Attachment\File;
use Illuminate\Http\Request;
use Orchid\Platform\Dashboard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\Models\Attachment;
use Symfony\Component\HttpFoundation\Response;
use Orchid\Platform\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class AttachmentController.
 */
class AttachmentController extends Controller
{
    /**
     * @var Attachment
     */
    protected $attachment;

    /**
     * AttachmentController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.systems.attachment');
        $this->attachment = Dashboard::modelClass(Attachment::class);
    }

    /**
     * @param Request $request
     *
     * @throws BindingResolutionException
     *
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        $attachment = [];
        foreach ($request->allFiles() as $files) {
            $files = Arr::wrap($files);

            foreach ($files as $file) {
                $attachment[] = $this->createModel($file, $request);
            }
        }

        $attachment = count($attachment) > 1 ? $attachment : reset($attachment);

        return response()->json($attachment);
    }

    /**
     * @param Request $request
     */
    public function sort(Request $request)
    {
        collect($request->get('files', []))
            ->each(function ($sort, $id) {
                $attachment = $this->attachment->find($id);
                $attachment->sort = $sort;
                $attachment->save();
            });
    }

    /**
     * Delete files.
     *
     * @param int     $id
     * @param Request $request
     */
    public function destroy(int $id, Request $request)
    {
        $storage = $request->get('storage', 'public');
        $this->attachment->findOrFail($id)->delete($storage);
    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return ResponseFactory|Response
     */
    public function update(int $id, Request $request)
    {
        $attachment = $this->attachment
            ->findOrFail($id)
            ->fill($request->all());

        $attachment->save();

        return response()->json($attachment);
    }

    /**
     * @param UploadedFile $file
     * @param Request      $request
     *
     * @return mixed
     */
    private function createModel(UploadedFile $file, Request $request)
    {
        $model = app()->make(File::class, [
            'file'  => $file,
            'disk'  => $request->get('storage', 'public'),
            'group' => $request->get('group'),
        ])->load();

        $model->url = $model->url();

        return $model;
    }

    /**
     * @return JsonResponse
     */
    public function media()
    {
        $attachments = $this->attachment->filters()->limit(30)->get();

        return response()->json($attachments);
    }
}
