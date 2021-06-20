<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Submission;
use App\Models\Indicator;
use App\Models\Attachment;
use App\Models\InputSubmission;

class IndicatorSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'submission_id',
        'indicator_id',
        'result'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function evidence()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function values()
    {
        return $this->hasMany(InputSubmission::class, 'indicator_submission_id', 'id');
    }
}
