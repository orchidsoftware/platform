<?php

declare(strict_types=1);

namespace Orchid\Attachment;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;

/**
 * This trait is used to relate or attach multiple files with Eloquent models.
 */
trait Attachable
{
    /**
     * Get all the attachments associated with the given model.
     *
     * @param string|null $group
     *
     * @return MorphToMany
     */
    public function attachment(?string $group = null): MorphToMany
    {
        $query = $this->morphToMany(
            Dashboard::model(Attachment::class),
            'attachmentable',
            'attachmentable',
            'attachmentable_id',
            'attachment_id'
        );

        if ($group !== null) {
            $query->where('group', $group);
        }

        return $query
            ->orderBy('sort');
    }
}
