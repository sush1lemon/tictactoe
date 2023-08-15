<?php

use App\Http\Controllers\GameController;
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

Route::get('/', function (Request $request) {
    $uToken = $request->cookie('x-tic-tac-toe');
    if (!$uToken) {
        Cookie::queue('x-tic-tac-toe', "random", 60*60*360);
    }
    return Inertia::render("Home");
});

//Route::post('/find-match');

Route::get('/play/{game}', [GameController::class, "play"]);


Route::prefix('/game/{game}')->group(function (){
    Route::post('/move', [GameController::class, 'makeMove']);
    Route::post('/events');
});
