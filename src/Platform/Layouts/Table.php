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
     * @throws \Throwable
     */
    public function build($post)
    {
        $form = $this->generatedTable($post);

        try {
            $view = view($this->template, [
                'form' => $form,
            ])->render();
        } catch (\Throwable $e) {
        }

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
