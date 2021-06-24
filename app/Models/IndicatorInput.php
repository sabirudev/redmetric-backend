<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Indicator;

class IndicatorInput extends Model
{
    use HasFactory;
    protected $fillable = ['indicator_id', 'label', 'unit'];
    protected $hidden = ['created_at', 'updated_at'];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }
}
