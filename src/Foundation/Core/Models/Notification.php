<?php

namespace Orchid\Foundation\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'url',
        'text',
        'read',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(self::class);
    }







}

/*
Schema::create('notification', function (Blueprint $table) {
    $table->increments('id');
    $table->bigInteger('user_id')->index()->unsigned();
    $table->string('type')->index();
    $table->string('url')->nullable();
    $table->string('text')->nullable();
    $table->boolean('read')->default(0);
    $table->timestamps();
});
*/