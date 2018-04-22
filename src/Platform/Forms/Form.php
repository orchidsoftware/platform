<?php

declare(strict_types=1);

namespace Orchid\Platform\Forms;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Form implements FormInterface
{
    use ValidatesRequests;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * Laravel Models for Forms.
     *
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    /**
     * Form constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->model = $this->model ? new $this->model() : null;
        $this->request = $request ?: request();
    }

    /**
     * @param $property
     *
     * @return array|string
     */
    public function __get($property)
    {
        if ($this->request->has($property)) {
            return $this->request->input($property);
        }
    }

    /**
     * Save Form.
     *
     * @return mixed
     */
    public function save()
    {
        $arg = func_get_args();

        // do validation
        if ($this->isValid()) {
            return $this->persist(...$arg);

            // return true
        }
    }

    /**
     * @return bool
     */
    protected function isValid()
    {
        $rules = $this->rules() ?: $this->rules;

        $this->validate($this->request, $rules);

        return true;
    }

    /**
     * Validation Rules Method.
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function persist()
    {
        //
    }

    /**
     * @return array
     */
    public function fields()
    {
        return $this->request->all();
    }

    /**
     * View Grid data.
     *
     * @return mixed
     */
    public function grid()
    {
        //
    }

    /**
     * Action of remote element.
     *
     * @return mixed
     */
    public function remove()
    {
        //
    }
}
