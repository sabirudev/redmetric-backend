<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
