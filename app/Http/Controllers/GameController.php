<?php

namespace App\Http\Controllers;

use App\Domain\Game\Actions\AddPlayerToQueue;
use App\Domain\Game\Actions\FindOpponent;
use App\Domain\Game\Actions\NewGame;
use App\Domain\Game\GameState;
use App\Domain\Game\Models\Game;
use App\Domain\Player\Models\Player;
use Cookie;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class GameController extends Controller
{

    public function serveHome(Request $request) {
        $uToken = $request->cookie('x-tic-tac-toe');
        $random = Str::random(256);
        $player = null;
        if (!$uToken) {
            Cookie::queue('x-tic-tac-toe', $random, 60*60*360);
        } else {
            $player = Player::query()
                ->where('token', $uToken)
                ->first();
        }
        return Inertia::render("Home", [
            "player" => $player,
        ]);
    }

    public function play(Game $game)
    {
        return Inertia::render("Play", [
            "game" => $game
        ]);
    }

    public function findMatch(Request $request, FindOpponent $findOpponent, NewGame $newGame)
    {
        $token = $request->cookie('x-tic-tac-toe');
        $player = Player::query()->where('token', $token)->first();
        if ($player) {
            $opponent = $findOpponent->do($player);
            if ($opponent) {
                $game = $newGame->do($player, $opponent);
                return response()->json(['game' => $game]);
            }
        }

        return response()->json(['game' => null]);
    }

    public function makeMove(Game $game)
    {
        $gameState = new GameState($game);


//        $gState->makeMove()
    }
}
