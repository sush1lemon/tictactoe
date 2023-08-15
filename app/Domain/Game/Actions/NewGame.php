<?php

namespace App\Domain\Game\Actions;

use App\Domain\Game\Models\Game;
use App\Domain\Game\Models\GameQueue;
use App\Domain\Player\Models\Player;

class NewGame
{
    public function do(Player $p1, Player $p2) : Game
    {

        GameQueue::query()
            ->whereIn('player_id', [$p1->id, $p1->id])
            ->delete();

        return Game::query()
            ->create([
                'round' => 1,
                'x_player' => $p1,
                'o_player' => $p2,
            ]);
    }
}
