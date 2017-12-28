<?php

namespace App\Core\Behaviors\Single;

use Orchid\Platform\Behaviors\Single;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class DemoPage extends Single
{
    /**
     * @var string
     */
    public $name = 'Demo page';

    /**
     * @var string
     */
    public $description = 'Demonstrative page';

    /**
     * @var string
     */
    public $slug = 'demo-page';

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
            'body'        => 'tag:wysiwyg|name:body|max:255|required|title:Name Articles',
            'body2'       => 'tag:markdown|name:body2|max:255|required|title:Name Articles',
            'picture'     => 'tag:picture|name:picture|max:255|title:Indexing|help:Allow search bots to index page|width:500|height:300',
            'datetime'    => 'tag:datetime|type:text|name:open|max:255|required|title:Opening date|help:The opening event will take place',
            'free'        => 'tag:checkbox|name:robot|max:255|required|title:Free|help:Event for free|placeholder:Event for free|default:1',
            'block'       => 'tag:code|name:block|title:Code Block|help:Simple web editor',
            'title'       => 'tag:input|type:text|name:title|max:255|required|title:Article Title|help:SEO title',
            'description' => 'tag:textarea|name:description|max:255|required|rows:5|title:Short description',
            'keywords'    => 'tag:tags|name:keywords|max:255|required|title:Keywords|help:SEO keywords',
            'robot'       => 'tag:robot|name:robot|max:255|required|title:Indexing|help:Allow search bots to index page',
            'list'        => 'tag:list|name:list|max:255|title:Indexing|help:Allow search bots to index page',
            'phone'       => 'tag:input|type:text|name:name|required|title:Phone|help:Number Phone|mask:(999) 999-9999',
            // need api key 'place'       => 'tag:place|name:place|max:255|required|title:Place|help:place for google maps',
        ];
    }

    /**
     * @return array
     */
    public function modules() : array
    {
        return [
            UploadPostForm::class,
        ];
    }
}
