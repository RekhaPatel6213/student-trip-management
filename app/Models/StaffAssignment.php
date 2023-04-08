<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAssignment extends Model
{
    use HasFactory;

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'trip_date',
        'user_id',
        'work_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'notes' => 'array',
    ];

    public function getTripDateAttribute($value)
    {
        return \App\Helpers\Helper::DateFormate($value, config("constants.DATE_FORMATE"));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function work()
    {
        return $this->belongsTo(Work::class, 'work_id');
    }
}
