<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'created_by', 'is_private'];

    public function users()
    {
        return $this->belongsToMany(User::class)
                ->withPivot('points')
                ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

