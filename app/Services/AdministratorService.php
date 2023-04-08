<?php

namespace App\Services;

use App\Repositories\AdministratorRepository;
use App\Models\Administrator;

class AdministratorService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new AdministratorRepository();
    }

    public function list(int $schoolId = null)
    {
        return $this->repository->getQueryBuilder(null, 'first_name', 'asc')
                    ->when($schoolId !== null, function ($query) use($schoolId) {
                        $query->where('school_id', $schoolId);
                    })
                    ->with(['district:id,name', 'school:id,name', 'state:id,code', 'city:id,name'])
                    ->get();
    }

	public function create(array $requestData)
    {
        return $this->repository->store($requestData);
    }

    public function update(array $requestData, Administrator $administrator)
    {
        return $this->repository->store($requestData, $administrator);
    }

    public function bulkDelete(array $requestData)
    {
        return $this->repository->bulkDelete($requestData);
    }

    public function withFind(int $administratorId)
    {
        return $this->repository->withFind(['district:id,name', 'school:id,name', 'state:id,code', 'city:id,name'], $administratorId);
    }
}