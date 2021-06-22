<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Attachment;
use App\Models\JurySubmission;

class Jury extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'tax_number',
        'address',
        'title',
        'position',
        'company'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploads()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function submissions()
    {
        return $this->hasMany(JurySubmission::class);
    }
}
