<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends Model
{
    use SoftDeletes;

    public const YES = 'YES',
                 NO = 'NO';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
       'first_name',
       'last_name',
       'email',
       'title',
       'position',
       'district_id',
       'school_id',
       'school2',
       'phone',
       'fax',
       'address',
       'city_id',
       'state_id',
       'zip',
       'comments',
    ];

    protected $appends = [
        'full_name'
    ];

    /**
     * Set the administrator's firstname in ucwords
     *
     * @param  string  $value
     * @return void
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords($value);
    }

    /**
     * Set the administrator's lastname in ucwords
     *
     * @param  string  $value
     * @return void
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords($value);
    }

    /**
     * get the administrator's name in ucwords
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
       return trim(ucfirst($this->first_name).' '.ucfirst($this->last_name));
    }

    public function getTitleAttribute($value)
    {
        return config('constants.administratorTitles')[$value];
    }

    public function getPositionAttribute($value)
    {
        return config('constants.administratorPositions')[$value];
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
