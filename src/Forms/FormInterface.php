<?php

namespace Orchid\Forms;

interface FormInterface
{
    /**
     * @return mixed
     */
    public function grid();

    /**
     * @return mixed
     */
    //public function get();

    /**
     * @return mixed
     */
    public function save();

    /**
     * @return mixed
     */
    public function remove();
}
