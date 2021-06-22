<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndicatorCriteria;
use App\Models\IndicatorInput;

class Indicator extends Model
{
    use HasFactory;
    protected $fillable = [
        'indicator_criteria_id',
        'code',
        'description',
        'unit'
    ];

    public function criteria()
    {
        return $this->belongsTo(IndicatorCriteria::class, 'indicator_criteria_id', 'id');
    }

    public function inputs()
    {
        return $this->hasMany(IndicatorInput::class);
    }
}
