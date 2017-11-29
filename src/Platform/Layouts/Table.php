<?php

namespace Orchid\Platform\Layouts;

abstract class Table
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.table";

    /**
     * @var string
     */
    public $data;

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
        ])->render();

        return $view;
    }

    /**
     * @param $post
     *
     * @return array
     */
    private function generatedTable($post)
    {
        return [
            'data'   => $post->get($this->data),
            'fields' => $this->fields(),
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [];
    }
}
