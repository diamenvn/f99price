<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class PostModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['post_date', 'post_modified', 'created_at', 'updated_at'];
}
