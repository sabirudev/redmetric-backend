<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Submission;
use App\Models\Jury;

class JurySubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'submission_id',
        'jury_id',
        'total_points',
        'note'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'id');
    }

    public function jury()
    {
        return $this->belongsTo(Jury::class);
    }
}
