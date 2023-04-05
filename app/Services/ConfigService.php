<?php

namespace App\Services;
use App\Models\ConfigModel;
use App\Models\LogModel;
use Carbon\Carbon;

class ConfigService
{
    protected $configModel;
    protected $logModel;
    public function __construct(ConfigModel $configModel, LogModel $logModel)
    {
        $this->configModel = $configModel;
        $this->logModel = $logModel;
    }

    public function search($condition = [], $orderBy = [])
    {
        $results = $this->configModel;
        foreach ($condition as $key => $value) {
            $results = $results->where($key, $value);
        }

        $results = $results->orderBy("id", "DESC");

        foreach ($orderBy as $key => $value) {
            $results = $results->orderBy($key, $value);
        }
        
        $results = $results->with(['crawlSite', 'syncSite', 'log'])->paginate(config('paginate.limit'));
        return $results;
    }

    public function firstByCondition($condition, $orderBy = [])
    {
        $results = $this->configModel;
        foreach ($condition as $key => $value) {
            $results = $results->where($key, $value);
        }

        foreach ($orderBy as $key => $value) {
            $results = $results->orderBy($key, $value);
        }

        $results = $results->first();
        return $results;
    }

    public function firstRunConfig()
    {
        $results = $this->configModel;
        $results = $results->where('status', 1);
        $results = $results->where('run_next_time', '<=', Carbon::now());
        $results = $results->orderBy('sync_last_time', 'ASC');
        $results = $results->with(['crawlSite', 'syncSite', 'log']);
        $results = $results->first();
        return $results;
    }

    public function firstById($id)
    {
        $results = $this->configModel;
        $results = $results->where('_id', $id);
        $results = $results->first();
        return $results;
    }

    public function create($data)
    {
        $results = new $this->configModel;
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
