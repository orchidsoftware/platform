<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\Foundation\Validation\ValidatesRequests;

trait Structure
{
    use ValidatesRequests;

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
     * @var string
     */
    public $prefix = 'content';

    /**
     * Menu group name.
     *
     * @var null
     */
    public $groupname;

    /**
     * Status divider.
     *
     * @var null
     */
    public $divider = false;

    /**
     * Show the data to the user.
     *
     * @var bool
     */
    public $display = true;

    /**
     * Basic statuses possible for the object.
     *
     * @return array
     */
    public function status()
    {
        return [
            'publish' => __('Published'),
            'draft' => __('Draft'),
        ];
    }

    /**
     * Request Validation.
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function isValid(): array
    {
        return $this->validate(request(), $this->rules());
    }

    /**
     * Validation Request Rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Registered fields for main.
     *
     * @return mixed
     */
    abstract public function main(): array;

    /**
     * Registered fields for filling.
     *
     * @return mixed
     */
    abstract public function fields(): array;

    /**
     * Registered fields for options.
     *
     * @return mixed
     */
    abstract public function options(): array;

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
