<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'state_id',
        'status',
    ];
}
