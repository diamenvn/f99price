<?php

namespace App\Services;
use App\Models\ResultModel;

class ResultService
{
    protected $model;
    public function __construct(ResultModel $model)
    {
        $this->model = $model;
    }

    public function search($params = [], $orderBy = [])
    {
        $results = $this->model;
        
        if (isset($params['name']) && !empty($params['name'])) {
            $results = $results->where('name', 'like', '%' . $params['name'] . '%');
        }
        foreach ($orderBy as $key => $value) {
            $results = $results->orderBy($key, $value);
        }


        $results = $results->groupBy(['brand_id', 'name'])->select('name', 'price','url', 'brand_id', 'unit');
        
        $results = $results->select('name', 'price', 'url', 'brand_id', 'unit')->get();

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

    public function remove($target)
    {
        return $target->delete();
    }

    public function removeByCondition($condition = [])
    {
        $results = $this->model;
        foreach ($condition as $key => $value) {
            $results = $results->where($key, $value);
        }

        $results = $results->delete();
        return $results;
    }

    public function firstBetweenDate($name, $startDate, $endDate)
    {
        $results = $this->model;
        $results = $results->where('name', $name);
        $results = $results->where('created_at', '>=', $startDate);
        $results = $results->where('created_at', '<', $endDate);
        $results = $results->orderBy('created_at', 'DESC');
        $results = $results->first();
        return $results;
    }

    public function getBetweenDate($brandId, $startDate, $endDate)
    {
        $results = $this->model;
        $results = $results->where('brand_id', $brandId);
        $results = $results->where('created_at', '>=', $startDate);
        $results = $results->where('created_at', '<', $endDate);
        $results = $results->groupBy(['brand_id', 'name']);
        $results = $results->orderBy('created_at', 'DESC');
        $results = $results->get();
        return $results;
    }

    public function getByBrandId($brandId)
    {
        $results = $this->model;

        $results = $results->where('brand_id', $brandId);
        $results = $results->groupBy(['brand_id', 'name'])->select('name', 'price','url', 'brand_id', 'unit', 'thumbnail_url');
        
        $results = $results->select('name', 'price', 'url', 'brand_id', 'unit', 'thumbnail_url')->get();

        return $results;
    }
}
