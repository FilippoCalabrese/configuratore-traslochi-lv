<div
    class="w-full relative bg-center bg-opacity-30 bg-repeat flex flex-col h-screen"
    style="background-image: url('{{ asset('images/bg.svg') }}')"
>
    @include('livewire.partials.header', ['currentStep' => 1])

    <div class="flex flex-col p-4 py-10 md:py-0 items-center justify-center flex-1">
        <h1 class="font-bold text-4xl text-center pt-8">
            Acquista il tuo Trasloco in meno di 10 minuti.
        </h1>
        <p class="text-xl mt-2 text-center">
            Scegli, Calcola e Acquista il tuo Trasloco senza perdere tempo!
        </p>
        <img
            src="{{ asset('images/inizio.png') }}"
            class="w-[250px] left-[10vw] top-[40vh] -rotate-12 absolute lg:flex hidden"
            alt="Inizio"
        />

        <div class="w-full flex md:mt-14 mt-8 items-center justify-center">
            <form
                wire:submit="submitStep1"
                class="gap-4 p-8 md:p-10 card bg-gray-50 md:max-w-2xl w-full rounded-3xl border border-[#e4e7ec] shadow-[0_24px_60px_rgba(15,23,42,0.12)]"
            >
                <div class="relative w-full">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 icon-md pointer-events-none z-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input
                        class="input input-bordered input-soft h-12 pl-14 w-full text-lg"
                        placeholder="Nome e Cognome"
                        required
                        wire:model="firstName"
                    />
                </div>

                <div class="relative w-full">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 icon-md pointer-events-none z-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <input
                        class="input input-bordered input-soft h-12 pl-14 w-full text-lg"
                        placeholder="Email"
                        type="email"
                        required
                        wire:model="email"
                    />
                </div>

                <div class="relative w-full">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 icon-md pointer-events-none z-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <input
                        class="input input-bordered input-soft h-12 pl-14 w-full text-lg"
                        placeholder="Telefono"
                        type="tel"
                        required
                        wire:model="phone"
                    />
                </div>

                <div class="flex items-start gap-3 pt-2">
                    <input
                        type="checkbox"
                        id="contactConsent"
                        wire:model="contactConsent"
                        class="checkbox checkbox-primary mt-1"
                        required
                    />
                    <label for="contactConsent" class="text-sm text-gray-700 cursor-pointer">
                        Acconsento ad essere ricontattato per finalità relative alla richiesta di trasloco
                        <span class="text-red-500">*</span>
                    </label>
                </div>
                @error('contactConsent')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
                    <span wire:loading wire:target="submitStep1" class="loading loading-spinner"></span>
                    <span wire:loading.remove wire:target="submitStep1" class="flex items-center gap-1.5">
                        AVANTI
                        <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </span>
                </button>
            </form>
        </div>

        <div class="w-full mt-14 px-4">
            @include('livewire.partials.reviews-section')
        </div>
    </div>
</div>
