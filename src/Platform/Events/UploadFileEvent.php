<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Orchid\Attachment\Models\Attachment;

/**
 * Class UploadFileEvent.
 */
class UploadFileEvent
{
    use SerializesModels;

    /**
     * UploadFileEvent constructor.
     *
     * @param Attachment $attachment
     * @param int        $time
     */
    public function __construct(public Attachment $attachment, public int $time)
    {
        // ..
    }
}
