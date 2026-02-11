<div
    class="w-full bg-center bg-opacity-30 bg-repeat flex flex-col h-screen"
    style="background-image: url('{{ asset('images/bg.svg') }}')"
>
    @include('livewire.partials.header')

    <div class="bg-base-100 border-b px-4 py-2">
        @include('livewire.partials.progress-bar', ['currentStep' => 7])
    </div>

    <main class="flex w-full md:flex-row flex-col p-4 gap-4 justify-between flex-1">
        <div class="flex flex-1 gap-10 flex-col items-center justify-center w-full">
            <div class="p-8 h-max card bg-base-100 w-full max-w-xl shadow-md">
                <div class="w-full flex flex-col gap-5">
                    <h1 class="font-bold text-xl">
                        Prenotazione avvenuta con successo!
                    </h1>
                    <p class="text-gray-700">
                        Grazie per aver effettuato la prenotazione. Ti abbiamo inviato una mail con i dettagli della prenotazione.
                    </p>
                    <p class="text-gray-700">
                        Sarai ricontattato a breve per la finalizzazione dell'offerta commerciale.
                    </p>
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <button
                            type="button"
                            wire:click="restartConfiguration"
                            class="btn btn-primary w-full sm:w-auto"
                        >
                            Ricomincia una nuova configurazione
                            <svg class="icon-sm ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
