<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Period;
use App\Models\IndicatorSubmission;

class Submission extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'period_id',
        'publish'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function indicators()
    {
        return $this->belongsToMany(Indicator::class)
            ->using(IndicatorSubmission::class)
            ->withPivot('result', 'id');
    }
}
