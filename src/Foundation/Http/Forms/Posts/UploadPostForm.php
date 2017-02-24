<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Attachment;
use Orchid\Foundation\Core\Models\Post;

class UploadPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Загрузки';

    /**
     * Display Base Options.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @internal param null $type
     * @internal param null|Post $post
     */
    public function get()
    {
        return view('dashboard::container.posts.modules.upload', [
        ]);
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

    public function delete()
    {
    }
}
