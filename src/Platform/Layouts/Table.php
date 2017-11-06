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
        ])->render();

        return $view;
    }


    /**
     *
     */
    private function generatedTable($post)
    {
        $data = $post->get($this->data);
        //$data = $post->paginate();
        //$data = $post[$this->data];

        //if(!is_array($data)){
        //    $data = $data->toArray();
        //}

        //dd($data);


        return [
            'data'   => $data,
            'fields' => $this->fields(),
        ];
    }
}
