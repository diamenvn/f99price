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
}
