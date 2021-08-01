<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Attachment;
use App\Models\InputSubmission;
use Illuminate\Database\Eloquent\Relations\Pivot;

class IndicatorSubmission extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'submission_id',
        'indicator_id',
        'result'
    ];

    public function evidence()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function values()
    {
        return $this->hasMany(InputSubmission::class, 'indicator_submission_id', 'id');
    }

    public function juryValues()
    {
        return $this->hasMany(JuryIndicatorSubmission::class, 'indicator_submission_id', 'id');
    }
}
