<?php

namespace Orchid\Http\Forms\Posts;

use Illuminate\Contracts\View\View;
use Orchid\Core\Models\Attachment;
use Orchid\Forms\Form;

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
    public function get(): View
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
        if ($this->request->has('files')) {
            $files = $this->request->input('files');
            foreach ($files as $file) {
                $uploadFile = Attachment::find($file);
                $uploadFile->post_id = $post->id;
                $uploadFile->save();
            }
        }
    }
}
