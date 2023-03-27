<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class ResultModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'crawl_results';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [];

    protected $fillable = [

    ];

}
