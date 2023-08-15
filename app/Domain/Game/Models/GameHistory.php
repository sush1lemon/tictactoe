<?php

namespace App\Domain\Game\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    use HasUuids;

    protected $table = 'game_history';
    protected $fillable = [
        'game_id',
        'winner'
    ];
}
