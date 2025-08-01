<div>
    <div class="grid grid-cols-7 gap-6">
        <div wire:ignore class="bg-white sm:rounded-lg col-span-5 shadow-md">
            <div class="p-6">
                <form class="md:grid md:grid-cols-6 grid-cols-1 gap-8 space-y-2" method="post"
                      action="{{ route('orders.store') }}">
                    @csrf
                    <p class="col-span-1">Chọn món</p>
                    <select id="foods" wire:model="foodLists" placeholder="Chọn món đi..." autocomplete="off"
                            name="foods[]" class="col-span-5 text-base" multiple>
                        <option value="">Chọn món đi...</option>
                        @foreach($foods as $food)
                            <option value="{{ $food->id }}" @if(in_array($food->id, $foodLists)) selected @endif
                                    data-address="{{ $food->address }}"
                                    data-price="{{ number_format($food->price) . 'đ' }}"
                                    data-src="{{ asset($food->attachment()->first()?->url()) }}">
                                {{ $food->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="col-span-1">Ghi chú</p>
                    <textarea class="border border-gray-300 rounded col-span-5 resize-none w-full focus:ring-primary"
                              placeholder="Ghi chú..." rows="10" name="note" id="note">{{ $this->order?->description }}</textarea>
                    <div class="text-right col-span-6">
                        <button type="submit"
                                class="px-4 py-2 rounded-md text-white bg-primary outline-none hover:bg-primary-darker float-right">
                            Xác nhận
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden sm:rounded-lg col-span-2 shadow-md">
            <div class="p-6 bg-white space-y-4">
                <p class="text-lg font-bold">Đơn đã đặt</p>
                <div class="rounded-md border p-4 my-4">
                    @forelse($foodSelected as $item)
                        <div class="flex pb-2 @if(!$loop->last) mb-4 border-b border-secondary @endif gap-4">
                            <img class="aspect-square rounded-md w-[70px] h-[70px] border"
                                 src="{{ asset($item->attachment()->first()?->url()) }}">
                            <div>
                                <p class="text-md font-bold text-black">{{ $item->name }}</p>
                                <p class="text-secondary font-bold flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ number_format($item->price) }}đ</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-300">Chưa chọn món</p>
                    @endforelse
                </div>
                <div class="rounded-md border p-4 my-4">
                    <p class="text-lg font-bold flex justify-between">
                        <span>Tạm tính:</span>
                        <span class="text-secondary font-bold">{{ number_format($foodSelected->sum('price')) }}đ</span>
                    </p>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/js/tom-select.complete.min.js"></script>
        <script type="application/javascript">
            let control = new TomSelect('#foods', {
                create: true,
                plugins: ['dropdown_input', 'remove_button'],
                render: {
                    option: function (data, escape) {
                        return `<div class="flex p-4 gap-4 rounded-md border-b">` +
                            `<img class="aspect-square rounded-md md:w-[100px] w-[70px] md:h-[100px] h-[70px] border" src="${data.src}">` +
                            `<div class="space-y-2">` +
                            `<p class="text-xl font-bold text-black">${data.text}</p>` +
                            `<p class="text-gray-500 text-sm">` +
                            `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>` +
                            `${data.address}` +
                            `</p>` +
                            `<p class="text-secondary font-bold text-lg flex items-center">` +
                            `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>` +
                            `<span>${data.price}</span>` +
                            `</p>` +
                            `</div>` +
                            `</div>`;
                    },
                    item: function (item, escape) {
                        return `<div class="flex items-center gap-4 text-black"><img class="aspect-square rounded-md max-w-[50px] border" src="${item.src}">${item.text}</div>`;
                    }
                }
            });
        </script>
    </div>
</div>
