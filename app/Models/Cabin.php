<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabin extends Model
{
    use SoftDeletes;

    public const YES = 'YES',
                 NO = 'NO',
                 MALE = 'Male',
                 FEMALE ='Female';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'eligible_student',
        'gender',
        'is_eagle_point',
        'is_disability',
        'block_week',
    ];

    protected $casts = [
        'block_week' => 'array',
    ];

    /**
     * Set the school's code in uppercase.
     *
     * @param  string  $value
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    /**
     * Get the students for the cabin.
     */
    public function students()
    {
        return $this->hasMany(ScheduleStudent::class);
    }
}
