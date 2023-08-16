<script>
    export let games;
</script>

<main class="h-screen bg-slate-900 text-mauve-12 items-center flex flex-col">
    <div class="w-full md:w-1/3">
        <div class="flex flex-col mt-40 gap-8 px-8 py-6">
            <div class="flex flex-col gap-2">
                <a href="/" class="flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left"><path d="M6 8L2 12L6 16"/><path d="M2 12H22"/></svg>
                    Main Menu
                </a>
                <h1 class="text-3xl">Game History</h1>
                <h3 class="text-sm">View your recent games</h3>
            </div>

            <div>
                {#if games.length === 0}
                    No recent match found.
                {:else}
                    <div class="flex flex-col gap-4">
                        {#each games as game}
                            <div class="flex gap-4">
                                <h3>Game ID: {game.game_id}</h3>
                                <h3>Round: {game.game_round}</h3>
                                <h3>Winner: <b>{game.winner_info?.name ?? 'Draw' }</b></h3>
                            </div>
                        {/each}
                    </div>
                {/if}
            </div>
        </div>
    </div>
</main>
