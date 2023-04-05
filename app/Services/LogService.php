<?php

namespace App\Services;

use App\Models\SyncLogModel;

class LogService
{
    protected $model;
    public function __construct(SyncLogModel $model)
    {
        $this->model = $model;
    }

    public function search($condition = [], $orderBy = [])
    {
        $results = $this->model;
        foreach ($condition as $key => $value) {
            $results = $results->where($key, $value);
        }

        $results = $results->orderBy("id", "DESC");

        foreach ($orderBy as $key => $value) {
            $results = $results->orderBy($key, $value);
        }
        
        $results = $results->paginate(config('paginate.limit'));
        return $results;
    }

    public function firstById($id)
    {
        $results = $this->model;
        $results = $results->where('id', $id);
        $results = $results->first();
        return $results;
    }

    public function firstByCondition($condition, $orderBy = [])
    {
        $results = $this->model;
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
        $results = $this->model;
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
        $results = new $this->model;
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

    public function updateById($id, $data)
    {
        $target = $this->model->where('_id', $id)->first();
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
}
