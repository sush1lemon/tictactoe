<?php

namespace App\Domain\Game\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasUuids;
    protected $fillable = [
        'round',
        'x_player',
        'o_player',
        'status'
    ];

}
