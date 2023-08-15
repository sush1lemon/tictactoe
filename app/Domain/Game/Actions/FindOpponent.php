<?php

namespace App\Domain\Game\Actions;

use App\Domain\Game\Models\Game;
use App\Domain\Game\Models\GameQueue;
use App\Domain\Player\Models\Player;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Log;

class FindOpponent
{

    public function do(Player $player): ?Player
    {
        $retry = 0;
        $queue = $this->addPlayerToQueue($player);
        $loop = true;
        $opponent = null;

        while ($loop) {
            if ($retry >= 10) {
                break;
            }

            $check = GameQueue::query()
                ->where('player_id', '!=', $player->id)
                ->with('player')
                ->first();

            $game = Game::query()
                ->with(['playerOne', 'playerTwo'])
                ->where('status', 0)
                ->where(function (Builder $query) use ($player) {
                    $query->where('o_player', $player->id);
                    $query->orWhere('x_player', $player->id);
                })->first();


            Log::info("asdasd");
            if (!$check && !$game) {
                $retry += 1;
                sleep(1);
                continue;
            }


            $loop = false;
            if ($game) {
                $p1 = $game->playerOne;
                $p2 = $game->playerTwo;

                if ($p1->id == $player->id) {
                    $opponent = $p1;
                } else {
                    $opponent = $p2;
                }
            } else {
                $opponent = $check->player->id;
            }
        }

        if ($opponent == null) {
            $queue->delete();
        }

        return $opponent;
    }

    private function addPlayerToQueue(Player $player): GameQueue
    {
        return GameQueue::query()
            ->create(['player_id' => $player->id]);
    }
}
