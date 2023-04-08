<?php

namespace App\Services;

use App\Repositories\DistrictRepository;
use App\Models\District;

class DistrictService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new DistrictRepository();
    }

    public function list()
    {
        return $this->repository->getQueryBuilder(null, 'name', 'asc')->get();
    }

	public function create(array $requestData)
    {
        return $this->repository->store($requestData);
    }

    public function update(array $requestData, District $district)
    {
        return $this->repository->store($requestData, $district);
    }
}