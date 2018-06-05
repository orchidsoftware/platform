<?php

declare(strict_types=1);

namespace Orchid\Press\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Attachment
{
    /**
     * The Eloquent tags model name.
     *
     * @var string
     */
    protected static $attachmentModel = 'Orchid\Press\Models\Attachment';

    /**
     * @return string
     */
    public static function getAttachmentModel(): string
    {
        return static::$attachmentModel;
    }

    /**
     * @param $model
     */
    public static function setAttachmentModel($model): void
    {
        static::$attachmentModel = $model;
    }

    /**
     * @param null $type
     *
     * @param null $group
     * @return MorphToMany
     */
    public function attachment($type = null, $group = null): MorphToMany
    {
        $query = $this->morphToMany(
            static::$attachmentModel,
            'attachmentable',
            'attachmentable',
            'attachmentable_id',
            'attachment_id'
        );

        if (! is_null($type)) {
            $query->whereIn('extension', config('platform.attachment.'.$type));
        }

        if (! is_null($group)) {
            $query->where('attachmentable_group', $group);
        }

        return $query;
    }
}
