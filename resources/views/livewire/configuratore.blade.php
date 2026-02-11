<div class="w-full min-h-screen">
    @if($step === 1)
        @include('livewire.steps.step1')
    @elseif($step === 2)
        @include('livewire.steps.step2')
    @elseif($step === 3)
        @include('livewire.steps.step3')
    @elseif($step === 4)
        @include('livewire.steps.step4')
    @elseif($step === 5)
        @include('livewire.steps.step5')
    @elseif($step === 6)
        @include('livewire.steps.step6')
    @elseif($step === 7)
        @include('livewire.steps.step7')
    @endif
</div>
