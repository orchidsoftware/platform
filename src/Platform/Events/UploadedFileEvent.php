<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Orchid\Attachment\Models\Attachment;

/**
 * Class UploadedFileEvent.
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
