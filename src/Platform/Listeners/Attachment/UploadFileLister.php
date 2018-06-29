<?php

declare(strict_types=1);

namespace Orchid\Platform\Listeners\Attachment;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Orchid\Platform\Events\UploadFileEvent;
use Orchid\Attachment\BaseTemplate;

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

        foreach (config('attachment.images', []) as $key => $template) {
            try {
                $template = new $template($event->attachment);
                $this->saveImageProcessing($event->attachment, $key, $template);
            } catch (\Exception $exception) {
                Log::info($exception->getMessage(), [
                    'attachment' => $event->attachment,
                ]);
            }
        }
    }

    /**
     * @param \Orchid\Attachment\Models\Attachment $attachment
     * @param string                               $name
     * @param \Orchid\Attachment\BaseTemplate      $template
     */
    private function saveImageProcessing(Attachment $attachment, string $name, BaseTemplate $template)
    {
        if (! is_null($name)) {
            $name = '_'.$name;
        }

        $name = sha1($this->time.$attachment->getAttribute('original_name')).$name.'.'.$attachment->getAttribute('extension');

        $content = Image::make($attachment->read())
            ->filter($template)
            ->encode($template->extension, $template->quality);

        Storage::disk($attachment->getAttribute('disk'))->put(date('Y/m/d', $this->time).'/'.$name, $content, [
            'mime_type' => $attachment->getMimeType(),
        ]);
    }
}
