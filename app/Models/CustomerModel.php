<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class CustomerModel extends Authenticatable
{
    use Notifiable;
    protected $connection = 'mongodb';
    protected $collection = 'accounts';
    protected $primaryKey = '_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'uid',
        'pid',
        'fid',
        'data',
        'time'
    ];
}
