<?php

namespace Orchid\Platform\Layouts;

abstract class Table
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.table";

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
        $form = $this->generatedTable($post);

        $view = view($this->template, [
            'form' => $form,
            //'build' => $this->recustiveBuild($layout,$post)
        ])->render();

        return $view;
    }


    /**
     *
     */
    private function generatedTable($post)
    {

        $data = $post->paginate();

        return [
            'data'   => $data,
            'fields' => $this->fields(),
        ];
    }

}
