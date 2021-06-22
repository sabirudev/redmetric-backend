<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndicatorSubmission;
use App\Models\IndicatorInput;

class InputSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'indicator_submission_id',
        'indicator_input_id',
        'value'
    ];

    public function indicatorSubmit()
    {
        return $this->belongsTo(IndicatorSubmission::class, 'indicator_submission_id', 'id');
    }

    public function input()
    {
        return $this->belongsTo(IndicatorInput::class, 'indicator_input_id', 'id');
    }
}
