<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function list()
    {
        return $this->repository->getQueryBuilder(null, 'name', 'asc')
                                ->with(['role:id,name'])
                                ->get();
    }

	public function create(array $requestData)
    {
        $requestData['name'] = $requestData['first_name'].' '.$requestData['last_name'];
        $requestData['birth_date'] = \Carbon\Carbon::create($requestData['birth_date']);
        return $this->repository->store($requestData, null, true);
    }

    public function update(array $requestData, User $user)
    {
        $requestData['birth_date'] = \Carbon\Carbon::create($requestData['birth_date']);
        return $this->repository->store($requestData, $user);
    }

    public function bulkDelete(array $requestData)
    {
        return $this->repository->bulkDelete($requestData);
    }
}