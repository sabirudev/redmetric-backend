<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Village;
use App\Models\Submission;
use Laravel\Passport\HasApiTokens;
use Modules\Membership\Member;

class User extends \TCG\Voyager\Models\User
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
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

    public function village()
    {
        return $this->hasOne(Village::class, 'user_id', 'id');
    }

    public function membership()
    {
        return $this->hasOne(Member::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'user_id', 'id');
    }

    public function jury()
    {
        return $this->hasOne(Jury::class);
    }
}
