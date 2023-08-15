<?php

namespace App\Domain\Game\Actions;

use App\Domain\Game\Models\Game;
use App\Models\User;

class NewGame
{
    public function do(User $p1, User $p2) : Game
    {
        return Game::query()
            ->create([
                'x_player' => $p1,
                'o_player' => $p2,
            ]);
    }
}
