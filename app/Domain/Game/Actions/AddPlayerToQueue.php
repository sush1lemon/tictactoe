<?php

namespace App\Domain\Game\Actions;

use App\Domain\Game\Models\GameQueue;
use App\Domain\Player\Models\Player;

class AddPlayerToQueue
{
    public function do(Player $player) : GameQueue
    {
        return GameQueue::query()
            ->create(['player_id' => $player->id]);
    }
}
