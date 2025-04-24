<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'nation',
        'position',
        'team_id',
        'age',
        'born',
        'matches_played',
        'starts',
        'minutes',
        'goals',
        'assists',
    ];

    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class, 'team_id');
    }


    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class)->withPivot('points');
    }
    
}
