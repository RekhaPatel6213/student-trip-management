<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

     /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'status',
    ];
}
