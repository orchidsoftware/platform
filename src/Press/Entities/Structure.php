<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\Support\Facades\Validator;

trait Structure
{
    /**
     * Visible name of entity.
     *
     * @var
     */
    public $name = '';

    /**
     * Visible description of entity.
     *
     * @var string
     */
    public $description = '';

    /**
     * A unique name for entity.
     *
     * @var string
     */
    public $slug = '';

    /**
     * Display Icon.
     *
     * @var string
     */
    public $icon = 'icon-folder';

    /**
     * @deprecated
     *
     * Fields for content.
     *
     * @var array
     */
    public $fields = [];

    /**
     * @var string
     */
    public $prefix = 'content';

    /**
     * Menu group name.
     *
     * @var null
     */
    public $groupname = null;

    /**
     * Status divider.
     *
     * @var null
     */
    public $divider = null;

    /**
     * Show the data to the user.
     *
     * @var bool
     */
    public $display = true;

    /**
     * Container for HTML render.
     *
     * @var null
     */
    private $cultivated = null;

    /**
     * Basic statuses possible for the object.
     *
     * @return array
     */
    public function status()
    {
        return [
            'publish' => trans('platform::post/base.status_list.publish'),
            'draft'   => trans('platform::post/base.status_list.draft'),
        ];
    }

    /**
     * Request Validation.
     *
     * @return bool
     */
    public function isValid() : bool
    {
        Validator::make(request()->all(), $this->rules())->validate();

        return true;
    }

    /**
     * Validation Request Rules.
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

    /**
     * Registered fields for main.
     *
     * @return mixed
     */
    abstract public function main() : array;

    /**
     * Registered fields for filling.
     *
     * @return mixed
     */
    abstract public function fields() : array;

    /**
     * Registered fields for options.
     *
     * @return mixed
     */
    abstract public function options() : array;

    /**
     * Language support for recording.
     *
     * @return array
     */
    public function locale(): array
    {
        return config('press.locales');
    }
}
