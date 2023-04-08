<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const ACTIVE = 'ACTIVE',
                 INACTIVE = 'INACTIVE';

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'status',
    ];

    public function scopeRole($query)
    {
        return $query->whereNotIn('id', [config('constants.USER_ROLE_ID')]);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
