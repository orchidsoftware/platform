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
     * @var Attachment
     */
    public $attachment;

    /**
     * @var int
     */
    public $time;

    /**
     * UploadFileEvent constructor.
     */
    public function __construct(Attachment $attachment, int $time)
    {
        $this->attachment = $attachment;
        $this->time = $time;
    }
}
