<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\District;

class DistrictRepository extends BaseRepository
{
    public function model()
    {
        return District::class;
    }
}