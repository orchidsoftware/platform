<?php

namespace Orchid\Platform\Http\Forms\Posts;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Core\Models\Attachment;
use Orchid\Platform\Forms\Form;

class UploadPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Uploads';

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
        return view('dashboard::container.posts.modules.upload');
    }

    /**
     * @param null $type
     * @param null $post
     *
     * @return mixed|void
     */
    public function persist($type = null, $post = null)
    {
        $entity = $type->model::find($post->id);

        if ($this->request->filled('files')) {
            $files = $this->request->input('files');
            foreach ($files as $file) {
                $entity->attachment()->attach($file);
            }
        }
    }
}
