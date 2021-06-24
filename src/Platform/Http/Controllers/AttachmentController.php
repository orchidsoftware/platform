<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Events\UploadedFileEvent;
use Symfony\Component\HttpFoundation\Response;

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
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        $attachment = collect($request->allFiles())
            ->flatten()
            ->map(function (UploadedFile $file) use ($request) {
                return $this->createModel($file, $request);
            });

        $response = $attachment->count() > 1 ? $attachment : $attachment->first();

        return response()->json($response);
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
     * @param string  $id
     * @param Request $request
     */
    public function destroy(string $id, Request $request)
    {
        $storage = $request->get('storage', 'public');
        $this->attachment->findOrFail($id)->delete($storage);
    }

    /**
     * @param string  $id
     * @param Request $request
     *
     * @return ResponseFactory|Response
     */
    public function update(string $id, Request $request)
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
     * @throws BindingResolutionException
     *
     * @return mixed
     */
    private function createModel(UploadedFile $file, Request $request)
    {
        $model = resolve(File::class, [
            'file'  => $file,
            'disk'  => $request->get('storage'),
            'group' => $request->get('group'),
        ])->load();

        $model->url = $model->url();

        event(new UploadedFileEvent($model));

        return $model;
    }

    /**
     * @return JsonResponse
     */
    public function media()
    {
        $attachments = $this->attachment->filters()->limit(20)->get();

        return response()->json($attachments);
    }
}
