<?php

namespace App\Domain\Game\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = [
        'x_player',
        'o_player',
    ];

}
