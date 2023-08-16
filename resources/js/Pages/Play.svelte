<script>
    import DefaultLayout from "@/Layouts/DefaultLayout.svelte";
    import {onMount} from "svelte";
    import {router} from "@inertiajs/svelte";

    export let game;
    export let errors;

    let gameMoves = [];

    let gameState = [];
    let turn = 1;
    let moves = 0;
    let message = '';
    let ended = false;
    let round = 1;
    let winner = null

    $: playerOne = game.player_one;
    $: playerTwo = game.player_two;

    $: if (ended) {
        console.log(ended, winner)
        if (winner == null) {
            message = "Draw"
        } else {
            if (playerOne.id === winner) {
                message = `${playerOne.name} won!`
            } else {
                message = `${playerTwo.name} won!`
            }
        }
    } else {
        message = turn === 0 ? `It's ${playerOne.name} turn` : `It's ${playerTwo.name} turn`;
    }

    const winningPatterns = [
        [[0, 0], [0, 1], [0, 2]],
        [[1, 0], [1, 1], [1, 2]],
        [[2, 0], [2, 1], [2, 2]],
        [[0, 0], [1, 0], [2, 0]],
        [[0, 1], [1, 1], [2, 1]],
        [[0, 2], [1, 2], [2, 2]],
        [[0, 0], [1, 1], [2, 2]],
        [[0, 2], [1, 1], [2, 0]],
    ];

    const initBoard = function () {
        gameState = new Array(3);
        for (let i = 0; i < gameState.length; i++) {
            gameState[i] = new Array(3).fill(null);
        }
        turn = Math.floor(Math.random() * 2);
        moves = 0;
        ended = false;
        gameMoves = [];
        winner = false
    }

    const makeMove = function (row, col) {
        if (gameState[row][col] === null && !ended) {
            const player = turn === 0 ? game.player_one.id : game.player_two.id
            gameState[row][col] = player
            turn = turn === 0 ? 1 : 0;
            moves += 1;
            const base = row === 0 ? 1 : (row === 1 ? 4 : 7);
            gameMoves.push({
                game_id: game.id,
                game_round: round,
                player_id: player,
                position: base + col
            })
        }
        winner = getWinner();
        if (winner) {
            ended = true;
        }
        if (moves === 9) {
            winner = null
            ended = true;
        }
    }

    const getWinner = function () {
        for (const pattern of winningPatterns) {
            const values = [];
            for (const [row, col] of pattern) {
                values.push(gameState[row][col]);
            }

            if (new Set(values).size === 1 && values[0] !== null) {
                return values[0];
            }
        }

        return null
    }

    const saveBoardState = function (stop = false) {
        router.put(`/game/${game.id}`, {
            moves: gameMoves,
            round,
            stop,
            winner,
        })
    }

    const newGame = function () {
        saveBoardState();
        round += 1;
        initBoard()
    }

    const stop = function () {
        saveBoardState(true);
    }

    onMount(() => {
        initBoard();
    })


</script>

<DefaultLayout>

    <div class="flex justify-between mb-10  w-full max-w-lg">
        <div class="flex flex-col items-center gap-2 font-medium">
            <h3 class="text-2xl">{ game.player_one.name} </h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-x">
                <path d="M18 6 6 18"/>
                <path d="m6 6 12 12"/>
            </svg>
        </div>
        <div class="">
            <h3 class="text-2xl">{ message }</h3>
        </div>
        <div class="flex flex-col items-center gap-2 font-medium">
            <h3 class="text-2xl">{ game.player_two.name }</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-circle">
                <circle cx="12" cy="12" r="10"/>
            </svg>
        </div>
    </div>

    <div class="grid grid-rows-3 grid-cols-3 gap-2 max-w-lg">
        {#each gameState as row, ri}
            {#each row as col, ci}
                <button
                    class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer font-bold transition-all"
                    on:click={() => makeMove(ri, ci)}>
                    {#if (col)}
                        {#if col === playerOne.id}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-x">
                                <path d="M18 6 6 18"/>
                                <path d="m6 6 12 12"/>
                            </svg>
                        {:else if col === playerTwo.id}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-circle">
                                <circle cx="12" cy="12" r="10"/>
                            </svg>
                        {/if}
                    {/if}
                </button>
            {/each}
        {/each}
    </div>

    {#if ended}
        <div class="mt-4 flex justify-between gap-4">
            <button class="border px-4 py-2 rounded-md font-medium" on:click={newGame}>Continue</button>
            <button class="border px-4 py-2 rounded-md font-medium" on:click={stop}>Stop</button>
        </div>
    {/if}

</DefaultLayout>
