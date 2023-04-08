<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class TripInvite extends Model
{
    use HasFactory;

    public const YES = 'YES',
                 NO = 'NO',
                 SEND = 'SEND',
                 SEEN = 'SEEN',
                 COMPLETED = 'COMPLETED',
                 WEEK = 'WEEK',
                 DAY = 'DAY',
                 BEAR = 'bear_creek',
                 EAGLE = 'eagle_point';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'school_id',
        'invite_url',
        'type',
        'village_type',
        'remind',
        'remind_date',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function scopeVillage($query, $villageType)
    {
        $query->where('village_type', $villageType);
    }  

    public function getRemindDateAttribute($value)
    {
        return $value !== null ? Helper::DateFormate($value, config("constants.DATE_FORMATE")) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value !== null ? Helper::DateFormate($value, config("constants.DATE_FORMATE")) : null;
    }    
}
