<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleStudent extends Model
{
    use SoftDeletes;

    public const YES = 'YES',
                 NO = 'NO',
                 MALE = 'MALE',
                 FEMALE = 'FEMALE';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'schedule_id',
        'student_name',
        'first_name',
        'last_name',
        'gender',
        'is_disability',
        'teacher_cabin_id',
        'cabin_id',
        'note',
        'free_meal',
        'free_amount',
        'paid_meal',
        'paid_amount',
        'reduced_meal',
        'reduced_amount',
    ];

    /**
     * Set the student's name in ucwords
     *
     * @param  string  $value
     * @return void
     */
    public function setStudentNameAttribute($value)
    {
        $this->attributes['student_name'] = ucwords($value);
    }

    public function cabin()
    {
        return $this->belongsTo(Cabin::class, 'cabin_id');
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }
}
