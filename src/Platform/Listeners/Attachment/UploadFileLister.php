<?php

declare(strict_types=1);

namespace Orchid\Platform\Listeners\Attachment;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Orchid\Platform\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Orchid\Platform\Events\UploadFileEvent;

/**
 * Class UploadFileLister.
 */
class UploadFileLister implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var int
     */
    public $time;

    /**
     * Handle the event.
     *
     * @param Login $event
     *
     * @return void
     */
    public function handle(UploadFileEvent $event)
    {
        $this->time = $event->time;

        if (substr($event->attachment->getMimeType(), 0, 5) !== 'image') {
            return;
        }

        foreach (config('platform.images', []) as $key => $value) {
            try {
                $this->saveImageProcessing($event->attachment, $key, $value['width'], $value['height'], $value['quality']);
            } catch (\Exception $exception) {
                Log::info($exception->getMessage(), [
                    'attachment' => $event->attachment,
                ]);
            }
        }
    }

    /**
     * @param \Orchid\Platform\Models\Attachment $attachment
     * @param null                               $name
     * @param null                               $width
     * @param null                               $height
     * @param int                                $quality
     */
    private function saveImageProcessing(Attachment $attachment, $name = null, $width = null, $height = null, $quality = 100)
    {
        if (! is_null($name)) {
            $name = '_'.$name;
        }

        $name = sha1($this->time.$attachment->original_name).$name.'.'.$attachment->extension;

        $content = Image::make($attachment->physicalPath)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode($attachment->original_name, $quality);

        Storage::disk($attachment->getAttribute('disk'))->put(date('Y/m/d', $this->time).'/'.$name, $content, [
            'mime_type' => $attachment->getMimeType(),
        ]);
    }
}
