<?php

declare(strict_types=1);

namespace Orchid\Platform\Traits;

use Orchid\Attachment\Models\Attachment;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Orchid\Platform\Dashboard;

/**
 * Trait Attachment.
 */
trait AttachTrait
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
