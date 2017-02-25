<?php

namespace Orchid\Foundation\Core\Models;

class Advertising extends Post
{
    /**
     * @var string
     */
    protected $postType = 'advertising';


    public function __construct(array $attributes = [])
    {
        if (!key_exists('type', $attributes)) {
            $attributes['type'] = $this->postType;
        }

        parent::__construct($attributes);
    }
}
