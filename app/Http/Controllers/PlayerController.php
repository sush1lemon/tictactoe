<?php

namespace App\Http\Controllers;

use App\Domain\Player\Actions\NewPlayer;
use App\Domain\Player\Models\Player;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlayerController extends Controller
{

    public function savePlayer(Request $request, NewPlayer $newPlayer)
    {
        $token = $request->cookie('x-tic-tac-toe');
        $valid = $this->validate($request, ['name' => 'required']);

        $newPlayer->do($valid['name'], $token);
        return to_route('home');
    }
}
