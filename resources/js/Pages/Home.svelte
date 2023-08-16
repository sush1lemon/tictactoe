<script>
    import DefaultLayout from "@/Layouts/DefaultLayout.svelte";
    import {modalStore} from "@skeletonlabs/skeleton";
    import {router} from "@inertiajs/svelte";

    let player1 = localStorage.getItem('player_1') ?? '';
    let player2 = localStorage.getItem('player_2') ?? '';


    const p1Modal = {
        type: 'prompt',
        // Data
        title: 'Enter player 1 name',
        // Populates the input value and attributes
        valueAttr: {type: 'text', minlength: 3, maxlength: 10, required: true},
        // Returns the updated response value
        response: (r) => {
            if (r) {
                player1 = r;
                localStorage.setItem('player_1', r)
                modalStore.trigger(p2Modal);
            }
        },
    };


    const p2Modal = {
        type: 'prompt',
        // Data
        title: 'Enter player 2 name',
        // Populates the input value and attributes
        valueAttr: {type: 'text', minlength: 3, maxlength: 10, required: true},
        // Returns the updated response value
        response: (r) => {
            if (r) {
                player2 = r;
                localStorage.setItem('player_2', r)
                console.log(player1, player2)
                // saveUser(r)
            }
        },
    };

    const fillName = function () {
        console.log(player1, player2)
        if (player1 !== '') {
            modalStore.trigger(p2Modal);
        } else {
            modalStore.trigger(p1Modal);
        }
    }

    const startGame = function () {
        router.post('/new-game', {
            player1,
            player2
        })
    }

</script>

<DefaultLayout>
    <div class="flex flex-col justify-between items-center">
        {#if player1 !== '' && player2 !== ''}
            <div class="flex flex-col items-center gap-8">
                <h3 class="text-2xl md:text-3xl lg:text-4xl break-words text-center">Welcome <b>{ player1 }</b> and <b>{ player2 }</b></h3>
                <button on:click={startGame}
                        class="border px-9 py-3 text-center rounded text-4xl font-medium cursor-pointer text-mauve-12 hover:bg-white hover:text-slate-900 transition-all">
                    Start
                </button>
                <a href="/history" class="mt-20 text-lg">See Game History</a>
            </div>
        {:else}
            <button on:click={fillName}
                    class="border px-9 py-3 text-center rounded text-4xl font-medium cursor-pointer text-mauve-12 hover:bg-white hover:text-slate-900 transition-all">
                Start New Game
            </button>
        {/if}
    </div>
</DefaultLayout>
