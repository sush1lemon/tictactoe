<?php

namespace App\Domain\Player\Actions;

use App\Domain\Player\Models\Player;

class NewPlayer
{
    public function do(string $name, string $token) : Player
    {
        return Player::query()
            ->updateOrCreate([
                'name' => $name,
                'token' => $token,
            ]);
    }
}
