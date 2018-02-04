<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Orchid\Platform\Core\Models\Post;
use Orchid\Platform\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * @param null $tag
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($tag = null)
    {
        $tags = Post::allTags()->latest('count')->limit(10);

        if (! is_null($tag)) {
            $tags = $tags->where('name', 'like', '%'.$tag.'%');
        }

        $tags = $tags->get()->transform(function ($item) {
            return [
                'id'    => $item['name'],
                'text'  => $item['name'],
                'count' => $item['count'],
            ];
        });

        return response()->json($tags);
    }
}
