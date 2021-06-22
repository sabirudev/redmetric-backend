<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Village extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'since',
        'address',
        'website',
        'province',
        'head',
        'secretary',
        'amount_male',
        'amount_female',
        'amount_productive_age'
    ];

    public function account()
    {
        return $this->belongsTo(User::class);
    }
}
