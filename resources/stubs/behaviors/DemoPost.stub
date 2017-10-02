<?php

namespace App\Core\Behaviors\Many;

use Orchid\Platform\Behaviors\Many;
use Orchid\Platform\Http\Forms\Posts\BasePostForm;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class DemoPost extends Many
{
    /**
     * @var string
     */
    public $name = 'Demo post';

    /**
     * @var string
     */
    public $description = 'Demonstrative post';

    /**
     * @var string
     */
    public $slug = 'demo';

    /**
     * Slug url /news/{name}.
     *
     * @var string
     */
    public $slugFields = 'name';

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'id'             => 'sometimes|integer|unique:posts',
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'name'        => 'tag:input|type:text|name:name|max:255|required|title:Name Articles|help:Article title',
            'body'        => 'tag:wysiwyg|name:body|max:255|required|rows:10',
            'datetime'    => 'tag:datetime|type:text|name:open|max:255|required|title:Opening date|help:The opening event will take place',
            'free'        => 'tag:checkbox|name:robot|max:255|required|title:Free|help:Event for free|placeholder:Event for free|default:1',
            'block'       => 'tag:code|name:block|title:Code Block|help:Simple web editor',
            'title'       => 'tag:input|type:text|name:title|max:255|required|title:Article Title|help:SEO title',
            'description' => 'tag:textarea|name:description|max:255|required|rows:5|title:Short description',
            'keywords'    => 'tag:tags|name:keywords|max:255|required|title:Keywords|help:SEO keywords',
            'robot'       => 'tag:robot|name:robot|max:255|required|title:Indexing|help:Allow search bots to index page',
        ];
    }

    /**
     * @return array
     */
    public function modules() : array
    {
        return [
            BasePostForm::class,
            UploadPostForm::class,
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            'name'       => 'Name',
            'publish_at' => 'Date of publication',
            'created_at' => 'Date of creation',
        ];
    }
}
