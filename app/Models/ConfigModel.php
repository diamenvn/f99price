<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class ConfigModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'config';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['updated_at', 'created_at', 'sync_last_time', 'run_last_time', 'run_next_time'];

    public function crawlSite()
    {
        return $this->hasOne(CrawlSiteModel::class, '_id', 'crawl_site_id');
    }

    public function syncSite()
    {
        return $this->hasOne(SyncSiteModel::class, '_id', 'sync_site_id');
    }

    public function log()
    {
        return $this->hasOne(SyncLogModel::class, 'config_id', '_id');
    }

}
