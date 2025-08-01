<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-primary leading-tight">
            {{ __('Sáng nay ăn gì?') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-3xl font-bold mb-4 text-center md:text-left">Đặt món nào!</p>
            @livewire('order-food', ['order' => $order])
        </div>
    </div>
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/css/tom-select.css" rel="stylesheet">
        <style>
            .ts-dropdown, .ts-control, .ts-control input{
                font-size: unset;
            }
            .ts-dropdown-content {
                max-height: 400px;
            }
        </style>
    @endpush

</x-app-layout>
