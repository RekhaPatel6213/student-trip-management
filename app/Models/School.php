<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    public const YES = 'YES',
                 NO = 'NO',
                 SEND = 'SEND',
                 SEEN = 'SEEN';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'type',
        'district_id',
        'email',
        'phone',
        'fax',
        'is_eagle_point',
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

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function schoolAdministrator()
    {
        return $this->hasMany(Administrator::class);
    }

    public function administrator()
    {
        return $this->hasOne(Administrator::class)->where('position', 'A');
    }

    public function principal ()
    {
        return $this->hasOne(Administrator::class)->where('position', 'P');
    }

    public function preScheduleRequest()
    {
        return $this->hasOne(Schedule::class)->orderBy('id','desc');
    }

    public function scopeInvite($query, $schoolIds, $isEaglePoint, $field)
    {
        $query->whereNotIn('id', $schoolIds)->where('is_eagle_point', $isEaglePoint)->whereNotNull($field);
    }
}
