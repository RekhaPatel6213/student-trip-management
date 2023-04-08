<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\EmailTemplate;

class EmailTemplateRepository extends BaseRepository
{
    public function model()
    {
        return EmailTemplate::class;
    }
}