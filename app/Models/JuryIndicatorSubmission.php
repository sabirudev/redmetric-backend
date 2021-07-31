<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndicatorSubmission;
use App\Models\Jury;

class JuryIndicatorSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'indicator_submission_id',
        'jury_id',
        'point',
        'note'
    ];

    public function indicatorSubmit()
    {
        return $this->belongsTo(IndicatorSubmission::class, 'indicator_submission_id', 'id');
    }

    public function jury()
    {
        return $this->belongsTo(Jury::class);
    }
}
