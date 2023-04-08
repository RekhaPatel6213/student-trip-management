<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Trip;

class TripRepository extends BaseRepository
{
    public function model()
    {
        return Trip::class;
    }
}