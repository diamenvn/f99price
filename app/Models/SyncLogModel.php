<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class SyncLogModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'sync_logs';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['updated_at', 'created_at', 'lasted_post_time'];
}
