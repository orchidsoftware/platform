<?php

namespace Orchid\Foundation\Core\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    /**
     * @var string
     */
    private $treeName = '';


    /**
     * @var array
     */
    protected $fillable = [
        'section_id',
        'content',
        'slug',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'content' => 'array',
        'slug' => 'string',
        'section_id' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function post()
    {
        return $this->hasMany(Post::class);
    }



    public function getTree($delimiter = '/', $local = null){

        $local = $local ?:  App::getLocale();
        $this->treeName = $this->content[$local]['name'];
        $tree = $this->recurseTree($this,$delimiter,$local);

        if($tree !== false) {
            $this->recurseTree($this,$delimiter,$local);
        }

        return $this->treeName;


    }


    /**
     * @param $model
     * @return bool
     */
    private function recurseTree($model,$delimiter,$local){
        if(!is_null($model->section_id)){
           $parrent = $this->find($model->section_id);
           $this->treeName = $parrent->content[$local]['name'] . $delimiter . $this->treeName;
        }
        return false;
    }


}
