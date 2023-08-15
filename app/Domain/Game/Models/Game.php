<?php

namespace App\Domain\Game\Models;

use App\Domain\Player\Models\Player;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasUuids;
    protected $fillable = [
        'round',
        'x_player',
        'o_player',
        'status'
    ];

    public function playerOne(): BelongsTo {
        return $this->belongsTo(Player::class, 'x_player');
    }

    public function playerTwo(): BelongsTo {
        return $this->belongsTo(Player::class, 'o_player');
    }
}
