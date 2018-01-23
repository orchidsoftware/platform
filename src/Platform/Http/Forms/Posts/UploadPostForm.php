<?php

namespace Orchid\Platform\Http\Forms\Posts;

use Orchid\Platform\Forms\Form;
use Illuminate\Contracts\View\View;
use Orchid\Platform\Core\Models\Post;

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
     * UploadPostForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('dashboard::post/uploads.tabs.uploads');
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
        return view('dashboard::container.posts.modules.upload', ['storage' => $this->storage]);
    }

    /**
     * @param null $type
     * @param null $post
     *
     * @return mixed|void
     */
    public function persist($type = null, $post = null)
    {
        $entity = Post::find($post->id);

        if ($this->request->filled('files')) {
            $files = $this->request->input('files');
            foreach ($files as $file) {
                $entity->attachment()->attach($file);
            }
        }
    }
}
