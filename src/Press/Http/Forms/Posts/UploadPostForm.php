<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Posts;

use Orchid\Press\Models\Post;
use Orchid\Forms\Form;
use Illuminate\Contracts\View\View;

class UploadPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Uploads';

    /**
     * @var string
     */
    public $storage = 'public';

    /**
     * @var string
     */
    public $mime = '';

    /**
     * UploadPostForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('platform::post/uploads.tabs.uploads');
        parent::__construct($request);
    }

    /**
     * Display Base Options.
     *
     * @return \Illuminate\Contracts\View\View
     *
     * @internal param null $type
     * @internal param null|Post $post
     */
    public function get() : View
    {
        return view('platform::container.posts.modules.upload', ['storage' => $this->storage, 'mime' => $this->mime]);
    }

    /**
     * @param null $type
     * @param null $post
     *
     * @return mixed|void
     */
    public function persist($type = null, $post = null)
    {
        if (! $this->request->filled('files')) {
            return;
        }

        $entity = Post::find($post->id);
        $files = $this->request->input('files');
        foreach ($files as $file) {
            $entity->attachment()->attach($file);
        }
    }
}
