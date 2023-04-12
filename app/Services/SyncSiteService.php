<?php

namespace App\Services;
use App\Models\SyncSiteModel;
use Carbon\Carbon;

class SyncSiteService
{
    protected $syncSiteModel;
    public function __construct(SyncSiteModel $syncSiteModel)
    {
        $this->syncSiteModel = $syncSiteModel;
    }

    public function search($condition = [], $orderBy = [])
    {
        $results = $this->syncSiteModel;
        foreach ($condition as $key => $value) {
            $results = $results->where($key, $value);
        }

        $results = $results->orderBy("id", "DESC");

        foreach ($orderBy as $key => $value) {
            $results = $results->orderBy($key, $value);
        }
        $results = $results->with(['config.log']);
        $results = $results->paginate(config('paginate.limit'));
        return $results;
    }

    public function firstById($id)
    {
        $results = $this->syncSiteModel;
        $results = $results->where('_id', $id);
        $results = $results->first();
        return $results;
    }

    public function firstByCondition($condition, $orderBy = [])
    {
        $results = $this->syncSiteModel;
        foreach ($condition as $key => $value) {
            $results = $results->where($key, $value);
        }

        foreach ($orderBy as $key => $value) {
            $results = $results->orderBy($key, $value);
        }

        $results = $results->first();
        return $results;
    }

    public function getByCondition($condition, $orderBy = [])
    {
        $results = $this->syncSiteModel;
        foreach ($condition as $key => $value) {
            $results = $results->where($key, $value);
        }

        foreach ($orderBy as $key => $value) {
            $results = $results->orderBy($key, $value);
        }
        
        $results = $results->get();
        return $results;
    }

    public function create($data)
    {
        $results = new $this->syncSiteModel;
        $results = $results->create($data);
        return $results;
    }

    public function update($target, $data)
    {
        foreach ($data as $key => $value) {
            $target[$key] = $value;
        }
        $results = $target->save();
        return $results;
    }

    public function remove($target)
    {
        return $target->delete();
    }

    public function getLastRowCheckConnectionByLimit($limit = 5)
    {
        $results = $this->syncSiteModel;
        $results = $results->where("last_check_connection", null);
        $results = $results->orWhere("last_check_connection", "<", Carbon::now());

        $results = $results->orderBy("last_check_connection", "ASC");
        
        $results = $results->limit($limit)->get();
        return $results;
    }
}
