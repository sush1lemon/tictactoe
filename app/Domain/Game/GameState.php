<?php

namespace App\Domain\Game;

use App\Domain\Game\Models\Game;
use App\Domain\Game\Models\GameMove;
use App\Domain\Player\Models\Player;
use Illuminate\Database\Eloquent\Collection;

class GameState
{
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    private function getMoves(): Collection {
        return GameMove::query()
            ->where('game_id', $this->game->id)
            ->get();
    }

    public function makeMove(Player $player, int $position): ?GameMove
    {
        $check = GameMove::query()
            ->where('game_id', $this->game->id)
            ->where('position', $position)
            ->first();

        if ($check->count() > 0) {
            return null;
        }

        return GameMove::query()
            ->create([
                'game_id' => $this->id,
                'user_id' => $player->id,
                'position' => $position,
            ]);
    }

    /**
     * Judge Board state
     * Returns 0 for ongoing, 1
     * @return Player|null
     */
    public function judgeBoardState() : ?Player
    {
        $moves = $this->getMoves();

        if ($moves->count() == 9){

            $board = array_fill(0, 3, array_fill(0, 3, null));

            foreach ($moves as $move) {
                $row = floor(($move['position'] - 1) / 3);
                $col = ($move['position'] - 1) % 3;
                $board[$row][$col] = $move['user_id'];
            }

            $winningPatterns = [
                [[0, 0], [0, 1], [0, 2]],
                [[1, 0], [1, 1], [1, 2]],
                [[2, 0], [2, 1], [2, 2]],
                [[0, 0], [1, 0], [2, 0]],
                [[0, 1], [1, 1], [2, 1]],
                [[0, 2], [1, 2], [2, 2]],
                [[0, 0], [1, 1], [2, 2]],
                [[0, 2], [1, 1], [2, 0]],
            ];

            foreach ($winningPatterns as $pattern) {
                $values = [];
                foreach ($pattern as $coord) {
                    $row = $coord[0];
                    $col = $coord[1];
                    $values[] = $board[$row][$col];
                }

                if (count(array_unique($values)) === 1 && $values[0] !== null) {
                    return $values[0];
                }
            }
        }

        return null;
    }
}
