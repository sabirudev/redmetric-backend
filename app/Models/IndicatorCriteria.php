<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Indicator;

class IndicatorCriteria extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name'];

    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'indicator_criteria_id', 'id');
    }
}
