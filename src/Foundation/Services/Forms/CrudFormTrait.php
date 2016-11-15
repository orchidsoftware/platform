<?php namespace Orchid\Foundation\Services\Forms;

trait CrudFormTrait
{

    /**
     * Verb GET
     * Action index
     */
    public function index()
    {
        return $this->get();
    }


    /**
     * Verb GET
     * Action create
     */
    public function create()
    {
        return $this->get();
    }


    /**
     * Verb POST
     * Action store
     */
    public function store()
    {
        return $this->save();
    }


    /**
     * Verb GET
     * Action show
     */
    public function show()
    {
        return $this->get();
    }

    /**
     * Verb GET
     * Action index
     */
    public function edit()
    {
        return $this->get();
    }

    /**
     * Verb PUT/PATCH
     * Action index
     */
    public function update()
    {
        return $this->save();
    }


    /**
     * Verb DELETE
     * Action destroy
     */
    public function destroy()
    {
        return $this->remove();
    }
}
