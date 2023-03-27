<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class BrandModel extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'brands';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(BrandItemModel::class, 'brand_id', '_id')->orderBy('_id', 'ASC');
    }

}
