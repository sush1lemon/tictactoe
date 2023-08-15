<?php

namespace App\Http\Controllers;

use App\Domain\Game\GameState;
use App\Domain\Game\Models\Game;
use Inertia\Inertia;

class GameController extends Controller
{

    public function play(Game $game)
    {
        return Inertia::render("Play", [
            "game" => $game
        ]);
    }

    public function matchUpPlayer()
    {

    }

    public function makeMove(Game $game)
    {
        $gameState = new GameState($game);


//        $gState->makeMove()
    }
}
