<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use HasFactory, SoftDeletes;

    public const ACTIVE = 'ACTIVE',
                 INACTIVE = 'INACTIVE',
                 STAFF = 'STAFF';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'is_eagle_point',
        'type',
        'status',
    ];

    public function scopeStaff($query)
    {
        return $query->where('type', 'STAFF')->where('status', 'ACTIVE');
    }
}
