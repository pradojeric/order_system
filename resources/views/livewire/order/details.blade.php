<div>
    <div class="pt-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center flex-col sm:flex-row mt-3">
                <div class="flex flex-col w-full">
                    <div class="grid grid-cols-2 md:grid-cols-8 sm:grid-cols-4">
                        @foreach ($categories as $category)
                        <x-menu-card :img="asset($category->icon)" :category="$category"
                            wire:click.prevent="viewDishes({{ $category->id ?? null }})"
                            class="{{ $selectedCategory == $category->id ? 'border-green-500' : '' }}" />
                        @endforeach
                        <x-menu-card :img=" asset('icons/Custom.png')" category="Custom"
                            wire:click.prevent="$emitTo('order.custom', 'addCustomDish')" />
                    </div>
                    <div class="flex max-h-full mt-3">
                        <div class="w-full">
                            @forelse ($dishes as $index => $dish)
                            <div
                                class="flex border justify-between items-center py-3 pl-2 pr-3 text-xs lg:text-sm @if(!$dish->status) text-gray-300 @endif">
                                <div class="flex items-center">
                                    <button type="button" wire:click.prevent.lazy="decrementQuantity({{ $index }})"><i
                                            class="fa fa-minus"></i></button>
                                    <x-input type="number" min="1" class="w-12 mx-2"
                                        wire:model="dishes.{{ $index }}.quantity" readonly />
                                    <button type="button" wire:click.prevent.lazy="incrementQuantity({{ $index }})"><i
                                            class="fa fa-plus"></i></button>
                                    <button
                                        @if($dish->add_on)
                                            wire:click.prevent="$emitTo('order.modal.add-on', 'addOn', '{{ $dish->id }}', '{{ $dishes[$index]['quantity'] }}')"
                                        @else
                                            wire:click.prevent="addDish({{ $dish->id }}, {{ $dishes[$index]['quantity'] }}, {{ $dishes[$index]['side'] }})"
                                        @endif
                                        class="text-white p-2 rounded ml-3
                                        {{ !$dish->status ? 'bg-gray-300' : 'bg-green-500 hover:bg-green-700'  }}">Add
                                    </button>
                                </div>
                                <span>
                                    {{ $dish->name }}
                                </span>
                                <span>
                                    {{ $dish->price_formatted }}
                                </span>
                            </div>
                            @empty
                            <div class="border p-5">
                                No entries
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="flex sm:mt-0 mt-3">
                    <div class="w-full ml-2">
                        <div class="overflow-y-auto border rounded-lg p-1.5 w-full sm:w-64 h-80 max-h-full">
                            @if($order)
                            @foreach ($oldOrders as $i => $item)
                            <div class="flex justify-around mb-5 xl:text-sm text-xs" wire:model="oldOrders.{{ $i }}">
                                <button type="button" class="w-5"
                                    wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $item->id }}, 0)">
                                    <i
                                        class="fa fa-minus-circle {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                                </button>
                                <div class="flex flex-col w-28">
                                    <div class="flex flex-col">
                                        <span>
                                            {{ $item->dish->name }}
                                        </span>
                                        <span class="text-xs">
                                            {!! $item->side_dishes ? 'with '.$item->side_dishes['side_name'] : '' !!}
                                        </span>
                                    </div>
                                    <div>
                                        X{{ $item['pcs'] }}
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                </div>
                            </div>
                            @endforeach
                            @foreach($oldCustomOrders as $i => $item)
                            <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                <button type="button" class="w-5"
                                    wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $item->id }}, 1)">
                                    <i
                                        class="fa fa-minus-circle {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                                </button>
                                <div class="flex flex-col w-28">
                                    <div class="flex flex-col">
                                        <span>

                                            {{ $item->name }} ({{ _('Custom') }})
                                        </span>
                                        <span class="text-xs">
                                            {{ "Desc: ".$item->description }}
                                        </span>
                                    </div>
                                    <div>
                                        X{{ $item['pcs'] }}
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @forelse ($orderedDishes as $i => $item)
                            <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                <button type="button" class="w-5" wire:click.prevent="removeDish({{ $i }})">
                                    <i class="fa fa-minus-circle text-red-500"></i>
                                </button>
                                <div class="flex flex-col w-28">
                                    <div class="flex flex-col">
                                        <span>
                                            {{ $item['name'] }}
                                        </span>
                                        <span class="text-xs">
                                            {{ array_key_exists('side_name', $item) && $item['side_name'] ? 'with '.$item['side_name'] : '' }}
                                            {{ array_key_exists('desc', $item) ? "Desc: ".$item['desc'] : '' }}
                                        </span>
                                    </div>
                                    <div>
                                        X{{ $item['quantity'] }}
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-sm">
                                No order Yet
                            </div>
                            @endforelse
                        </div>
                        <div class="mt-1">
                            <div class="text-lg font-bold flex flex-row justify-between">
                                <span>
                                    Total:
                                </span>
                                <span>
                                    ₱ {{number_format( $totalPrice, 2, '.', ',') }}
                                </span>
                            </div>
                            <div class="mt-3">
                                <button type="button" {{ $isReviewing ? 'disabled' : '' }}
                                    class="bg-green-500 hover:bg-green-700 py-3 w-full text-center rounded-lg text-white"
                                    wire:click.prevent="placeOrders">Proceed</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('order.review', ['table' => $table, 'action' => $action, 'order' => $order])
    @livewire('order.custom');
    @livewire('order.modal.add-on');
    @can('manage')
    @livewire('auth.passcode')
    @endcan

</div>
