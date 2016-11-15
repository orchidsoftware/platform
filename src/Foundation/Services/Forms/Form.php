<?php namespace Orchid\Foundation\Services\Forms;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

abstract class Form implements FormContract
{
    use ValidatesRequests;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $rules = [];


    /**
     * Laravel Models for Forms
     * @var
     */
    protected $model;

    /**
     * @var array
     */
    public $data = [];


    /**
     * Form constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->model = $this->model ? new $this->model : null;
        $this->request = $request ?: request();
    }


    /**
     * @return mixed
     */
    abstract public function persist();

    /**
     * @return mixed
     */
    abstract public function get();


    /**
     * Save Form
     * @param null $arg
     * @return mixed|null
     */
    public function save($arg = null)
    {
        // do validation
        if ($this->isValid()) {
            return $this->persist($arg);

            // return true;
        }

        return null;
    }


    /**
     * @return array
     */
    public function fields()
    {
        return $this->request->all();
    }


    /**
     * @return bool
     */
    protected function isValid()
    {
        $this->validate($this->request, $this->rules);

        return true;
    }



    /**
     * @param $property
     * @return array|string
     */
    public function __get($property)
    {
        if ($this->request->has($property)) {
            return $this->request->input($property);
        }
    }


    /**
     * Action of remote element
     * @return mixed
     */
    public function remove()
    {
        return null;
    }


    /**
     * View Grid data
     * @return mixed
     */
    public function grid()
    {
        return null;
    }
}
