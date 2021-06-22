<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'file'];

    /**
     * Get the parent attachable model.
     */
    public function attachable()
    {
        return $this->morphTo();
    }
}
