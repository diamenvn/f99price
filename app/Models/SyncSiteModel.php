<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class SyncSiteModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'sync_sites';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['updated_at', 'created_at', 'last_check_connection'];

    public function config()
    {
        return $this->hasMany(ConfigModel::class, 'sync_site_id', '_id');
    }
}
