<?php

namespace App\Domain\Game\Models;

use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    protected $fillable = [
        'game_id',
        'winner'
    ];
}
