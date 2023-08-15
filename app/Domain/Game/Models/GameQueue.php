<?php

namespace App\Domain\Game\Models;

use App\Domain\Player\Models\Player;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameQueue extends Model
{
    use HasUuids;


    protected $table = 'game_queue';
    protected $fillable = ['player_id'];


    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id', );
    }
}
