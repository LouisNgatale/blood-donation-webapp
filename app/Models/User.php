<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'Age',
        'Gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Roles::class, 'role_user');
    }

    /**
     * The donations that belong to the user.
     */
    public function donation(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Inventory::class,'donor_id');
    }

    /**
     * The requests that belong to the user.
     */
    public function requests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Requests::class,'recipient_id');
    }

    public function zone(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Zones::class);
    }

    public function generated_codes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RequestCode::class,'generated_by');
    }

    public function owning_codes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RequestCode::class,'owner_id');
    }
}
