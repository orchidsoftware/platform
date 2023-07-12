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
     * @var Attachment
     */
    public $attachment;

    /**
     * UploadedFileEvent constructor.
     */
    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }
}
