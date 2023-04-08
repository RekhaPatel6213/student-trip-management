<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'investment',
        'in_county_budget_category',
    ];
}
