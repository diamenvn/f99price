<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class SettingModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'setting';
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
