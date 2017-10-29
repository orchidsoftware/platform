<?php

namespace Orchid\Platform\Layouts;

use Orchid\Platform\Behaviors\Helpers;

abstract class Rows
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.row";

    /**
     * @return array
     */
    public function fields() : array
    {
        return [];
    }

    /**
     * @param $post
     *
     * @return array
     */
    public function build($post)
    {
        $form = Helpers::generateForm($this->fields(), $post);

        $view = view($this->template, [
            'form' => $form,
            //'build' => $this->recustiveBuild($layout,$post)
        ])->render();

        return $view;
    }
}
