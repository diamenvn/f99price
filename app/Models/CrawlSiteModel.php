<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class CrawlSiteModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'crawl_sites';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['updated_at', 'created_at', 'crawled_last_time'];

    public function config()
    {
        return $this->hasOne(ConfigModel::class, 'crawl_site_id', '_id');
    }
}
