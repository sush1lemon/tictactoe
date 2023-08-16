<?php

namespace App\Domain\Game\Models;

use App\Domain\Player\Models\Player;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameHistory extends Model
{
    use HasUuids;

    protected $table = 'game_history';
    protected $fillable = [
        'game_id',
        'game_round',
        'winner'
    ];

    public function winnerInfo(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'winner');
    }
}
