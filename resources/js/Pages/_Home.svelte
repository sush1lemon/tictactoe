<script>

    import DefaultLayout from "@/Layouts/DefaultLayout.svelte";
    import {localStorageStore, modalStore} from "@skeletonlabs/skeleton";

    import { router } from '@inertiajs/svelte'
    import axios from "axios";

    export let player;


    console.log('this is the player', player)

    let name = ''
    const modal = {
        type: 'prompt',
        // Data
        title: 'Tell us your name',
        body: 'Provide a name in the field below.',
        // Populates the input value and attributes
        value: name,
        valueAttr: {type: 'text', minlength: 3, maxlength: 10, required: true},
        // Returns the updated response value
        response: (r) => {
            if (r) {
                saveUser(r)
            }
        },
    };

    const findingMatchModal = {
        type: 'alert',
        title: 'Finding other player',
        body: 'Looking for other player to join the queue.',
        response: () => cancelMatchFind()
    }

    const showModal = function () {
        console.log('here')
        modalStore.trigger(modal);
    }

    const findMatch = function () {
        modalStore.trigger(findingMatchModal)
        axios.post('/find-match')
        setTimeout(() => {
            modalStore.close()
        }, 5000)
    }

    const cancelMatchFind = function () {
        console.log("im ending this match!")
    }

    const saveUser  = function (name) {
        router.post('/save-player', {
            name: name
        })
    }

</script>


<DefaultLayout>

    <div class="flex flex-col justify-between items-center">

        {#if (player)}
            <div class="flex flex-col gap-4">
                <h3 class="text-4xl font-medium">Welcome <b>{ player.name }!</b></h3>
                <button on:click={findMatch} class="border px-8 py-6 rounded text-4xl font-medium cursor-pointer text-mauve-12 hover:bg-white/90 hover:text-slate-900 transition-all">Start</button>
            </div>
            {:else }
            <button on:click={showModal} class="border px-8 py-6 rounded text-4xl font-medium cursor-pointer text-mauve-12 hover:bg-white/90 hover:text-slate-900 transition-all">Start New Game</button>
        {/if}

        <a href="/history" class="mt-20 text-lg">See game history</a>
    </div>
</DefaultLayout>

<!--<main class="h-screen bg-slate-900 text-mauve-12 flex flex-col justify-center items-center">-->


<!--&lt;!&ndash;    <div class="grid grid-rows-3 grid-cols-3 gap-2 max-w-lg">&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">x</div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">x</div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">x</div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">x</div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">x</div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">x</div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">x</div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">&ndash;&gt;-->
<!--&lt;!&ndash;            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle"><circle cx="12" cy="12" r="10"/></svg>&ndash;&gt;-->
<!--&lt;!&ndash;        </div>&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="border-2 flex items-center justify-center h-24 w-24 rounded-lg cursor-pointer">&ndash;&gt;-->
<!--&lt;!&ndash;            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>&ndash;&gt;-->
<!--&lt;!&ndash;        </div>&ndash;&gt;-->
<!--&lt;!&ndash;    </div>&ndash;&gt;-->

<!--    <div class="flex flex-col justify-between items-center">-->
<!--        <button class="border px-8 py-6 rounded text-4xl font-medium cursor-pointer text-mauve-12 hover:bg-white/90 hover:text-slate-900 transition-all">Start New Game</button>-->
<!--        <a href="/history" class="mt-20 text-lg">See game history</a>-->
<!--    </div>-->

<!--&lt;!&ndash;    <div class="mt-4">&ndash;&gt;-->
<!--&lt;!&ndash;        <button class="border px-4 py-2 rounded-md font-medium">Exit</button>&ndash;&gt;-->
<!--&lt;!&ndash;    </div>&ndash;&gt;-->

<!--</main>-->


