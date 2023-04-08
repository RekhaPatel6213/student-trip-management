<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\StaffAssignment;

class StaffAssignmentRepository extends BaseRepository
{
    public function model()
    {
        return StaffAssignment::class;
    }
}