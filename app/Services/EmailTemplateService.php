<?php

namespace App\Services;

use App\Repositories\EmailTemplateRepository;
use App\Models\EmailTemplate;

class EmailTemplateService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new EmailTemplateRepository();
    }

    public function list()
    {
        return $this->repository->getQueryBuilder(null, 'name', 'asc')->get();
    }

	public function create(array $requestData)
    {
        return $this->repository->store($requestData);
    }

    public function update(array $requestData, EmailTemplate $emailTemplate)
    {
        return $this->repository->store($requestData, $emailTemplate);
    }
}