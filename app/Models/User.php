<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'role_id',
        'birth_date',
        'phone',
        'fax',
        'c_street',
        'c_state_id',
        'c_city_id',
        'c_zip',
        'p_street',
        'p_state_id',
        'p_city_id',
        'p_zip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set the teachers's first_name & last_name.
     *
     * @param  string  $value
     * @return void
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    // public function getNameAttribute($value)
    // {
    //     return trim(ucfirst($this->first_name).' '.ucfirst($this->last_name));
    // }

    public function getBirthDateAttribute($value)
    {
        return \App\Helpers\Helper::DateFormate($value, config("constants.DATE_FORMATE"));
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
