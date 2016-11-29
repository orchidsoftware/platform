<?php

namespace Orchid\Foundation\Services\Type;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

abstract class Type implements TypeInterface
{
    /**
     * Name type.
     * @var
     */
    public $name = '';

    /**
     * @var string
     */
    public $slug = '';

    /**
     * @var string
     */
    public $icon = 'ion-ios-paper-outline';

    /**
     * Fields for content.
     * @var array
     */
    public $fields = [];

    /**
     * Relations.
     * @var
     */
    public $relations = [];

    /**
     * Available templates.
     * @var
     */
    public $templates = [];

    /**
     * @var Model
     */
    public $model = Post::class;


    /**
     * Request for Type.
     * @var
     */
    public $request = Request::class;


    /**
     * @var string
     */
    public $prefix = 'content';


    /**
     * @var null
     */
    private $cultivated = null;


    /**
     * To determine the properties by the function.
     * @var array
     */
    private $method = [
        'setName',
        'setRelations',
        'setTemplates',
    ];

    abstract public function setFields();

    abstract public function grid();

    /**
     * Parse the data fields.
     */
    protected function parseFields()
    {
        $data = $this->explodeFields($this->fields);

        foreach ($data as $name => $value) {
            $newField = collect();
            foreach ($value as $rule) {
                $newField[] = $this->parseStringFields($rule);
            }
            $this->fields[$name] = $newField->collapse();
        }
    }

    /**
     * Explode the rules into an array of rules.
     *
     * @param array $rules
     * @return array
     */
    protected function explodeFields(array $rules)
    {
        foreach ($rules as $key => $rule) {
            if (Str::contains($key, '*')) {
                $this->each($key, [$rule]);
                unset($rules[$key]);
            } else {
                if (is_string($rule)) {
                    $rules[$key] = explode('|', $rule);
                } elseif (is_object($rule)) {
                    $rules[$key] = [$rule];
                } else {
                    $rules[$key] = $rule;
                }
            }
        }

        return $rules;
    }

    /**
     * @param $rules
     * @return array
     */
    protected function parseStringFields($rules)
    {
        $parameters = [];
        // The format for specifying validation rules and parameters follows an
        // easy {rule}:{parameters} formatting convention. For instance the
        // rule "Max:3" states that the value may only be three letters.
        if (strpos($rules, ':') !== false) {
            list($rules, $parameter) = explode(':', $rules, 2);
            $parameters = $this->parseParameters($rules, $parameter);
        }

        return [
            $rules => empty($parameters) ? true : implode(' ', $parameters),
        ];
    }

    /**
     * Parse a parameter list.
     *
     * @param  string $rule
     * @param  string $parameter
     * @return array
     */
    protected function parseParameters($rule, $parameter)
    {
        if (strtolower($rule) == 'regex') {
            return [$parameter];
        }

        return str_getcsv($parameter);
    }

    /**
     * Validation Request Rules.
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @param string $language
     * @param string $prefix
     * @return string
     */
    public function generateForm($language = 'en', $post = null, $prefix = null)
    {
        $this->fields = $this->setFields();
        $this->parseFields();

        $fields = $this->fields;

        $form = '';
        foreach ($fields as $field => $config) {
            $field = config('content.fields.'.$config['tag']);
            $field = new $field;
            $config['lang'] = $language;


            if (! is_null($prefix)) {
                $config['prefix'] = $prefix;
            } else {
                $config['prefix'] = $this->prefix;
            }


            if (! is_null($post)) {
                $config['value'] = $post->getContent($config['name'], $language);
            }

            $field = $field->create($config);
            $form .= $field->render();
        }


        return $form;
    }

    /**
     * @return array
     */
    public function generateGrid()
    {
        $fields = $this->grid();
        $model = new $this->model;

        $data = $model->where('type', $this->slug)->paginate();

        return [
            'data' => $data,
            'fields' => $fields,
            'type' => $this,
        ];
    }

    /**
     * Reqeust Validation.
     * @return bool
     */
    public function isValid()
    {
        Validator::make(request()->all(), $this->rules())->validate();

        return true;
    }

    /**
     * @return bool
     */
    public function checkModules()
    {
        if (method_exists($this, 'setModules') && ! empty($this->setModules())) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function render()
    {
        if (! is_null($this->cultivated)) {
            return $this->cultivated;
        }

        $html = collect();
        $groups = $this->setModules();

        $argc = array_values(request()->getRouteResolver()->call($this)->parameters());

        foreach ($groups as $form) {
            if (! is_object($form)) {
                $form = new $form();
            }

            if (method_exists($form, 'get')) {
                $html->put($form->name, $form->get(...$argc));
            }
        }

        $this->cultivated = $html;

        return $this->cultivated;
    }
}
