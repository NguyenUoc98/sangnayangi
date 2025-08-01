<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-primary leading-tight">
            {{ __('Sáng nay ăn gì?') }}
        </h2>
    </x-slot>

    @livewire('choose-buyer')
</x-app-layout>
