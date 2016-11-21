<?php namespace Orchid\Foundation\Services\Field;


interface FieldInterface
{

    /**
     * Create function Field
     */
    public function create();


    /**
     * Render view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view();


}