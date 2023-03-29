<?php

namespace App\Services;
use App\Models\CrawlSiteModel;

class CrawlSiteService
{
    protected $crawlSiteModel;
    public function __construct(CrawlSiteModel $crawlSiteModel)
    {
        $this->crawlSiteModel = $crawlSiteModel;
    }

    public function search($condition = [], $orderBy = [])
    {
        $results = $this->crawlSiteModel;
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
        $results = $this->crawlSiteModel;
        $results = $results->where('_id', $id);
        $results = $results->first();
        return $results;
    }

    public function firstByCondition($condition, $orderBy = [])
    {
        $results = $this->crawlSiteModel;
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
        $results = $this->crawlSiteModel;
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
        $results = new $this->crawlSiteModel;
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
}
