<?php

namespace Orchid\Foundation\Http\Forms\Posts;

use Orchid\Foundation\Core\Models\File;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Services\Forms\Form;

class ImagesPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Изображения';

    /**
     * Display Base Options.
     * @param null $type
     * @param Post|null $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($type = null, Post $post = null)
    {
        return view('dashboard::container.posts.modules.images', [
        ]);
    }

    /**
     * @param null $type
     * @param null $post
     */
    public function persist($type = null, $post = null)
    {
        if ($this->request->has('files')) {
            $files = $this->request->input('files');
            foreach ($files as $file) {
                $uploadFile = File::find($file);
                $uploadFile->post_id = $post->id;
                $uploadFile->save();
            }
        }
    }

    public function delete()
    {
    }
}
