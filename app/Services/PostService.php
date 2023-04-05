<?php

namespace App\Services;
use App\Models\PostModel;

class PostService
{
    protected $postModel;
    public function __construct(PostModel $postModel)
    {
        $this->postModel = $postModel;
    }

    public function search($condition = [], $orderBy = [])
    {
        $results = $this->postModel;
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
        $results = $this->postModel;
        $results = $results->where('_id', $id);
        $results = $results->first();
        return $results;
    }

    public function firstByCondition($condition, $orderBy = [])
    {
        $results = $this->postModel;
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
        $results = $this->postModel;
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
        $results = new $this->postModel;
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

    public function getBySiteID($id)
    {
        $results = $this->postModel;
        $results = $results->where('site_id', $id);
        $results = $results->get();
        return $results;
    }

    public function countByIDWithStartDateEndDate($id, $startDate = null, $endDate = null)
    {
        $results = $this->postModel;
        if (isset($id)) {
            $results = $results->where('site_id', $id);
        }
        if (isset($startDate)) {
            $results = $results->where('created_at', '>=', $startDate);
        }
        if (isset($startDate)) {
            $results = $results->where('created_at', '<=', $endDate);
        }
        $results = $results->count();
        return $results;
    }
}
