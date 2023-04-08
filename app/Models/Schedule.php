<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    public const PENDING = 'PENDING',
                 CONFIRMED = 'CONFIRMED',
                 REGISTERED = 'REGISTERED',
                 CANCEL = 'CANCEL',
                 DAY = 'DAY',
                 WEEK = 'WEEK',
                 YES = 'YES',
                 NO = 'NO',
                 SENT = 'SENT',
                 SEEN = 'SEEN',
                 PAID ='PAID';

    public const STATUS = [ 
        'PENDING' => 'Pending',
        'CONFIRMED' => 'Confirmed',
        'REGISTERED' => 'Registered',
        'CANCEL' => 'Cancel'
    ];
    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'school_id',
        'invite_id',
        'type',
        'days',
        'trip_number',
        'trip_date',
        'teacher',
        'email',
        'students',
        'status',
        'confirmation_send',
        'confirmation_send_date',
        'bill_send',
        'bill_send_date',
        'bill_status',
        'student_eligibility',
        'send_meal_request',
        'free_amount',
        'paid_amount',
        'reduced_amount',
        'meal_name',
        'meal_title',
        'meal_email',
        'meal_phone',
        'meal_signature',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function getTripDateAttribute($value)
    {
        return \App\Helpers\Helper::DateFormate($value, config("constants.DATE_FORMATE"));
    }

    public function getBillSendDateAttribute($value)
    {
        return \App\Helpers\Helper::DateFormate($value, config("constants.DATE_FORMATE"));
    }

    public function studentInfo()
    {
        return $this->hasMany(ScheduleStudent::class, 'schedule_id');
    }
}
