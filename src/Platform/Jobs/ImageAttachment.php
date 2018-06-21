<?php

declare(strict_types=1);

namespace Orchid\Platform\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Queue\SerializesModels;
use Orchid\Platform\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class ImageAttachment.
 */
class ImageAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Orchid\Platform\Models\Attachment
     */
    protected $attachment;

    /**
     * @var int
     */
    private $time;

    /**
     * ImageAttachment constructor.
     *
     * @param \Orchid\Platform\Models\Attachment $attachment
     * @param int                                $time
     */
    public function __construct(Attachment $attachment, int $time)
    {
        $this->attachment = $attachment;
        $this->time = $this;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (substr($this->attachment->getMimeType(), 0, 5) !== 'image') {
            return;
        }

        foreach (config('platform.images', []) as $key => $value) {
            try {
                $this->saveImageProcessing($this->attachment, $key, $value['width'], $value['height'], $value['quality']);
            } catch (\Exception $exception) {
                Log::info($exception->getMessage(), [
                    'attachment' => $this->attachment,
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
