<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Cabin;

class CabinRepository extends BaseRepository
{
    public function model()
    {
        return Cabin::class;
    }
}