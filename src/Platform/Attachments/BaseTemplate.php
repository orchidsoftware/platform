<?php

declare(strict_types=1);

namespace Orchid\Platform\Attachments;

use Intervention\Image\Image;
use Orchid\Platform\Models\Attachment;
use Intervention\Image\Filters\FilterInterface;

/**
 * Class BaseTemplate.
 */
abstract class BaseTemplate implements FilterInterface
{
    /**
     * @var int
     */
    public $width = 100;

    /**
     * @var int
     */
    public $height = 100;

    /**
     * @var int
     */
    public $quality = 100;

    /**
     * @var \Orchid\Platform\Models\Attachment
     */
    public $attachment;

    /**
     * @var string
     */
    public $extension;

    /**
     * Small constructor.
     *
     * @param \Orchid\Platform\Models\Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
        $this->extension = $attachment->getAttribute('extension');
    }

    /**
     * @param \Intervention\Image\Image $image
     *
     * @return \Intervention\Image\Image
     */
    public function applyFilter(Image $image)
    {
        return $image->resize($this->width, $this->height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}
