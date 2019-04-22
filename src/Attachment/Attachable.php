<?php

declare(strict_types=1);

namespace Orchid\Attachment;

use Orchid\Platform\Dashboard;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Trait Attachable.
 */
trait Attachable
{
    /**
     * @param string $group
     *
     * @return MorphToMany
     */
    public function attachment(string $group = null): MorphToMany
    {
        $query = $this->morphToMany(
            Dashboard::model(Attachment::class),
            'attachmentable',
            'attachmentable',
            'attachmentable_id',
            'attachment_id'
        );

        if (! is_null($group)) {
            $query->where('group', $group);
        }

        return $query
            ->orderBy('sort', 'asc');
    }
}
