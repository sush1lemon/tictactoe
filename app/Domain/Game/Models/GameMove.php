<?php

namespace App\Domain\Game\Models;

use Illuminate\Database\Eloquent\Model;

class GameMove extends Model
{
    protected $fillable = [
        'user_id',
        'position',
    ];
}
