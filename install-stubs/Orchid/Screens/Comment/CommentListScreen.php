<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Comment;

use Orchid\Screen\Screen;
use Orchid\Press\Models\Comment;
use App\Orchid\Layouts\Comment\CommentListLayout;

class CommentListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Comments';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'User Comments';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $comments = Comment::with([
            'post' => function ($query) {
                $query->select('id', 'type', 'slug');
            },
        ])->latest()
            ->paginate();

        return [
            'comments' => $comments,
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            CommentListLayout::class,
        ];
    }
}
