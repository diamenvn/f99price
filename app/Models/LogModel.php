<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class LogModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'logs';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [];

    protected $fillable = [

    ];

    protected $dates = ['lasted_post_time', 'created_at', 'updated_at'];

}
