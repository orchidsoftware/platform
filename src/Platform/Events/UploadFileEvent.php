<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Orchid\Platform\Models\Attachment;

/**
 * Class UploadFileEvent
 */
class UploadFileEvent
{

    /**
     * @var \Orchid\Platform\Models\Attachment
     */
    public $attachment;

    /**
     * @var int
     */
    public $time;

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

}
