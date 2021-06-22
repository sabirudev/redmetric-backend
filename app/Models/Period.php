<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Submission;

class Period extends Model
{
    use HasFactory;
    protected $fillable = [
        'opened',
        'closed',
        'is_ended'
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
