<?php

namespace App\Http\Controllers;

use App\Domain\Game\GameState;
use App\Domain\Game\Models\Game;

class GameController extends Controller
{

    public function matchUpPlayer()
    {

    }

    public function makeMove(Game $game)
    {
        $gState = new GameState($game);

//        $gState->makeMove()
    }
}
