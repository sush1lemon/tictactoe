<?php

namespace App\Http\Controllers;

use App\Domain\Game\Actions\AddPlayerToQueue;
use App\Domain\Game\Actions\FindOpponent;
use App\Domain\Game\Actions\NewGame;
use App\Domain\Game\GameState;
use App\Domain\Game\Models\Game;
use App\Domain\Game\Models\GameHistory;
use App\Domain\Game\Models\GameMove;
use App\Domain\Player\Actions\NewPlayer;
use App\Domain\Player\Models\Player;
use Cookie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class GameController extends Controller
{

    public function serveHome(Request $request) {
        $uToken = $request->cookie('x-tic-tac-toe');
        $random = Str::random(100);
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

    public function history(Request $request) {
        $token = $request->cookie('x-tic-tac-toe');

        $player = Player::query()
            ->where('token', 'LIKE', "%$token%")
            ->get()->pluck('id');

        $games = Game::query()
            ->where(function (Builder $query) use ($player) {
                $query->whereIn('x_player', $player);
                $query->orWhereIn('o_player', $player);
            })
            ->get()->pluck('id');

        $result = GameHistory::query()
            ->with('winnerInfo')
            ->whereIn('game_id', $games)->get();

        return Inertia::render("History", [
            "games" => $result,
        ]);
    }

    public function newGame(Request $request, NewPlayer $newPlayer, NewGame $newGame)
    {
        $token = $request->cookie('x-tic-tac-toe');
        $validated = $request->validate([
            'player1' => 'required',
            'player2' => 'required',
        ]);


        $p1 = $newPlayer->do($validated['player1'], $token.$validated['player1']);
        $p2 = $newPlayer->do($validated['player2'], $token.$validated['player2']);

        $game = $newGame->do($p1, $p2);

        return to_route('play', [$game]);
    }

    public function update(Game $game, Request $request)
    {
        $validated = $request->validate([
            'moves' => 'required',
            'round' => 'required',
            'stop' => 'bool|nullable',
            'winner' => 'string|nullable',
        ]);

        $game->round = $validated['round'];
        $game->save();

        GameMove::query()
            ->insert($validated['moves']);

        GameHistory::create([
            'game_id' => $game->id,
            'game_round' => $validated['round'],
            'winner' => $validated['winner'],
        ]);

        if (in_array('stop', $validated) && $validated['stop']) {
            $game->status = 5;
            $game->save();
            return to_route('home');
        }
    }

    public function play(Game $game)
    {
        $game = $game->load(['playerOne', 'playerTwo']);
        return Inertia::render("Play", [
            "game" => $game,
        ]);
    }

    public function makeMove(Game $game)
    {
        $gameState = new GameState($game);
//        $gameState->makeMove()
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
}
