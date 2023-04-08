<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Models\Role;

class RoleService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new RoleRepository();
    }

    public function list()
    {
        return $this->repository->getQueryBuilder(null, 'name', 'asc')->withCount(['users'])->get();
    }

	public function create(array $requestData)
    {
        return $this->repository->store($requestData);
    }

    public function update(array $requestData, Role $role)
    {
        return $this->repository->store($requestData, $role);
    }
}