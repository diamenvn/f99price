<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class BrandItemModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'brands_item';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function setting()
    {
        return $this->hasOne(SettingModel::class, 'brand_item_id')->orderBy('_id', 'DESC');
    }

    public function brand()
    {
        return $this->belongsTo(BrandModel::class, 'brand_id')->orderBy('_id', 'DESC');
    }
}
