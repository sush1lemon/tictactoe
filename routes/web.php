<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GameController::class, "serveHome"])->name('home');
Route::post('/new-game', [GameController::class, "newGame"]);
Route::get('/history', [GameController::class, 'history']);

//Route::post('/save-player', [PlayerController::class, 'savePlayer']);
//Route::post('/find-match', [GameController::class, 'findMatch']);

Route::get('/play/{game}', [GameController::class, 'play'])->name('play');


Route::prefix('/game/{game}')->group(function (){
    Route::put('', [GameController::class, 'update']);
    Route::post('/move', [GameController::class, 'makeMove']);
    Route::post('/events');
});
