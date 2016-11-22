<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Foundation\Exceptions\TypeException;
use Orchid\Foundation\Facades\Dashboard;

class Post extends Model
{
    /**
     * @var string
     */
    protected $table = 'posts';


    /**
     * @var
     */
    protected $postType = null;

    /**
     * @var array
     */
    protected $fillable = [
        'types_id',
        'users_id',
        'type',
        'content',
        'page',
        'slug',
        'publish',
    ];



    /**
     * @var array
     */
    protected $casts = [
        'page' => 'boolean',
        'type' => 'string',
        'slug' => 'string',
        'content' => 'array',
        'publish' => 'timestamp',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param $getType
     * @return mixed
     * @throws TypeException
     */
    public function getType($getType){
        $types = Dashboard::types(true);
        foreach ($types as $type){
            if($type->slug == $getType){
                $this->postType = $type;
                break;
            }
        }

        if(is_null($this->postType)){
            throw new TypeException('Type is not found');
        }

        return $this;
    }


    /**
     * @return mixed
     */
    public function whereType(){
        return $this->where('type',$this->postType->slug);
    }


    /**
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this->postType, $property)) {
            return $this->postType->{$property}();
        }

        return $this->{$property};
    }



}
