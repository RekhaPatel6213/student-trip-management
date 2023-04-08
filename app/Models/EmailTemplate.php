<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        //'name',
        'subject',
        //'from_email',
        'message',
        'status',
    ];
    
    const TEMPLATE = [
        'PreScheduleTripRequest' => 'Pre-Schedule Trip Request',
        'DayTripConfirmed' => 'Day Trip Confirmed',
        'WeekTripConfirmed' => 'Week Trip Confirmed',
        'StudentInformation' => 'Student Information',
        'MealInformation' => 'Meal Information',
        'MealInformationSuccess' => 'Meal Information Success',
        'BillInformation' => 'Bill Information',
    ];

    public function scopeName($query, $name)
    {
        return $query->where('name', self::TEMPLATE[$name]);
    }
}
