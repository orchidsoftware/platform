<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Orchid\Attachment\Models\Attachment;

/**
 * Class ReplicateFileEvent.
 */
class ReplicateFileEvent
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
     * ReplicateFileEvent constructor.
     *
     * @param Attachment $attachment
     * @param int        $time
     */
    public function __construct(Attachment $attachment, int $time)
    {
        $this->attachment = $attachment;
        $this->time = $time;
    }
}
