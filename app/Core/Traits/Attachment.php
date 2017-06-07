<?php

namespace Orchid\Core\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Attachment
{

    /**
     * The Eloquent tags model name.
     *
     * @var string
     */
    protected static $attachmentModel = 'Orchid\Core\Models\Attachment';

    /**
     * @return string
     */
    public static function getTagsModel(): string
    {
        return static::$attachmentModel;
    }

    /**
     * @param $model
     */
    public static function setTagsModel($model): void
    {
        static::$attachmentModel = $model;
    }

    /**
     * @param null $type
     *
     * @return MorphToMany
     */
    public function attachment($type = null): MorphToMany
    {
        if (!is_null($type)) {
            return $this->morphToMany(static::$attachmentModel, 'attachmentable', 'attachment_relationships',
                'attachmentable_id', 'attachment_id')
                ->whereIn('extension', config('content.attachment.' . $type));
        }

        return $this->morphToMany(static::$attachmentModel, 'attachmentable', 'attachment_relationships',
            'attachmentable_id', 'attachment_id');
    }
}
