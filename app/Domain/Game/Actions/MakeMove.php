<?php

namespace App\Domain\Game\Actions;

use App\Domain\Game\Models\Game;
use App\Domain\Game\Models\GameMove;
use App\Domain\Player\Models\Player;

class MakeMove
{
    public function do(Game $game, Player $player, int $position): GameMove
    {
        return GameMove::query()
            ->create([
                'game_id' => $game->id,
                'player_id' => $player->id,
                'position' => $position,
            ]);
    }
}
