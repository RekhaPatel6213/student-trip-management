<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Administrator;

class AdministratorRepository extends BaseRepository
{
    public function model()
    {
        return Administrator::class;
    }
}