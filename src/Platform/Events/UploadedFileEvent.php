<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Orchid\Attachment\Models\Attachment;

/**
 * This class represents the event that fires after a file is uploaded.
 */
class UploadedFileEvent
{
    use SerializesModels;

    /**
     * UploadedFileEvent constructor.
     *
     * @param Attachment $attachment
     */
    public function __construct(public Attachment $attachment) {}
}
