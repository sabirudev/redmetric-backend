<?php

namespace Modules\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'phone',
        'image',
        'address',
        'state',
        'province',
        'city',
        'subdistrict',
        'gender',
        'about',
        'social_fb',
        'social_ig',
        'social_twitter',
        'social_youtube',
        'social_twitch'
    ];
    protected $hidden = ['created_at', 'updated_at', 'user_id'];
    protected $appends = ['image_url'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function identities()
    {
        return $this->hasMany('\Modules\Membership\MemberIdentity', 'member_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        return ($this->image) ? Storage::url($this->image) : '#';
    }
}
