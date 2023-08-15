<?php

namespace App\Domain\Game\Models;

use Illuminate\Database\Eloquent\Model;

class GameMove extends Model
{
    protected $fillable = [
        'game_id',
        'game_round',
        'player_id',
        'position',
    ];
}
