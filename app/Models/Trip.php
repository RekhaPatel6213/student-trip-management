<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;

    public const WEEK = 'WEEK',
                 DAY = 'DAY',
                 PENDING = 'PENDING',
                 ACTIVE = 'ACTIVE',
                 COMPLETED = 'COMPLETED';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'description',
        'start_date',
        'end_date',
        'type',
        'week_day',
        'status',
    ];

    public function scopeStatus($query)
    {
        return $query->where('status', '!=', self::COMPLETED);
    }

    public function scopeWeek($query)
    {
        return $query->where('status', '!=', self::COMPLETED)->where('type', Trip::WEEK);
    }

    public function scopeActiveTrip($query)
    {
        return $query->where('status', self::ACTIVE)->where('type', Trip::WEEK);
    }
}
