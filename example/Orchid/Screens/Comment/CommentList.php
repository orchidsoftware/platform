<?php
declare(strict_types=1);

namespace App\Orchid\Screens\Comment;

use Orchid\Press\Models\Comment;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\Comment\CommentListLayout;

class CommentList extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/comment.title';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/comment.description';
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'comment' => Comment::with([
                'post' => function ($query) {
                    $query->select('id', 'type', 'slug');
                },
            ])->latest()->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [
         ];
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