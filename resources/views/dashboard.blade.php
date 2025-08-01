<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-primary leading-tight">
            {{ __('Sáng nay ăn gì?') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-3xl font-bold mb-6 text-center md:text-left">Đơn đã đặt ngày hôm
                nay: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            <div class="w-full bg-white sm:rounded-lg md:p-6 p-4 shadow-md relative overflow-x-auto">
                @if($order && $order->details->count())
                    <div class="mb-4 flex justify-between items-center">
                        <p>
                            <span class="text-xl">Người được chọn: </span>
                            <span
                                class="text-3xl uppercase text-secondary font-bold">{{ $order->buyer?->name ?: 'Chưa chọn' }}</span>
                        </p>

                        <div class="space-x-2">
                            @if (!$order->buyer)
                                <a href="{{ route('spinner') }}"
                                   class="text-sm text-white font-semibold px-4 py-2 rounded-md bg-secondary shadow-md hover:bg-secondary-darker">
                                    Vòng quay may mắn
                                </a>
                                <a href="{{ route('orders.create') }}"
                                   class="text-sm text-white font-semibold px-4 py-2 rounded-md bg-primary shadow-md hover:bg-primary-darker">
                                    Đặt món</a>
                            @endif
                        </div>
                    </div>
                    <table class="w-full">
                        <tr class="bg-primary text-white">
                            <td class="font-bold border text-center py-2" rowspan="2">Người đặt</td>
                            <td class="font-bold border text-center py-2" colspan="2">Đơn đặt</td>
                            <td class="font-bold border text-center py-2" rowspan="2">Ghi chú</td>
                            <td class="font-bold border text-center py-2" rowspan="2">Thời gian</td>
                        </tr>
                        <tr class="bg-primary text-white">
                            <td class="font-bold border text-center py-2">Món</td>
                            <td class="font-bold border text-center py-2">Trạng thái</td>
                        </tr>

                        @foreach($order->details as $orderDetail)
                            <tr class="bg-white">
                                <td class="border text-center py-2 px-2 md:px-4"
                                    rowspan="{{ $orderDetail->foods->count() + 1 }}">
                                    {{ $orderDetail->user->name }}
                                </td>
                                <td class="m-0 p-0"></td>
                                <td class="m-0 p-0"></td>
                                <td class="border text-center py-2 px-2 md:px-4 min-w-[10rem] max-w-[30rem]"
                                    rowspan="{{ $orderDetail->foods->count() + 1}}">
                                    {{ $orderDetail->description }}
                                </td>
                                <td class="border text-center py-2 px-2 md:px-4 whitespace-nowrap"
                                    rowspan="{{ $orderDetail->foods->count() + 1}}">
                                    {{ $orderDetail->updated_at->format('H \g\i\ờ i') }}
                                </td>
                            </tr>
                            @foreach($orderDetail->foods as $food)
                                <tr class="bg-white">
                                    <td class="border py-2 px-2 md:px-4 space-y-2">
                                        <div class="flex items-center">
                                            <img
                                                class="w-[50px] aspect-square rounded-full border shadow-md hidden md:block mr-2"
                                                src="{{ asset($food->attachment()->first()?->url()) }}">
                                            <p class="whitespace-nowrap">{{ $food->name }}</p>
                                        </div>
                                    </td>
                                    <td class="border py-2 px-4 text-center">
                                        {{ $food->pivot->status }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                @else
                    <img class="opacity-25 h-48 mx-auto" src="{{ asset('images/bg01.webp') }}">
                    <div
                        class="text-xl text-gray-500 text-center font-bold top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 absolute">
                        <p class="mb-2">Chưa có đơn nào được đặt hôm nay</p>
                        <a href="{{ route('orders.create') }}"
                           class="text-sm text-white font-semibold px-4 py-2 rounded-md bg-secondary shadow-md hover:bg-secondary-darker">Đặt
                            món</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
