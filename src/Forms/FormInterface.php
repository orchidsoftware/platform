<?php

namespace Orchid\Forms;

interface FormInterface
{
    /**
     * The form of displaying many records in the table
     *
     * @return mixed
     */
    public function grid();

    /**
     * Action when saving
     *
     * @return mixed
     */
    public function save();

    /**
     * Deleting action
     *
     * @return mixed
     */
    public function remove();
}
