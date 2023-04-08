<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\School;

class SchoolRepository extends BaseRepository
{
    public function model()
    {
        return School::class;
    }
}