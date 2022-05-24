<div>
    <div class="border border-gray-300 rounded-lg p-1 flex flex-col h-64 justify-between flex-grow" x-data>
        <div class="px-1 text-right">
            @can('manage')
                <button wire:click.prevent="$emitTo('order.modal.transfer-table', 'transferOrder', {{ $order->id }})">
                    <i class="fa fa-exchange-alt"></i>
                </button>
            @endcan
            <button onclick="event.preventDefault(); print({{ $order->id  }})">
                <i class="fa fa-print"></i>
            </button>
        </div>
        <div class="flex">
            <div class="w-64 p-2 h-48">
                @if($order)
                <div>
                    <a href="{{ route('orders.show', ['action' => $action, 'order' => $order]) }}">
                        <ul class="list-unstyled text-xs">
                            <li>Order # {{ $order->order_number }}</li>
                            <li>
                                Amount: ₱ {{number_format( $order->totalPrice(), 2, '.', ',') }}
                                <span class="line-through">
                                    {{ $order->enable_discount ? number_format( $order->totalPriceWithoutDiscount(), 2, '.', ',') : '' }}
                                </span>
                            </li>
                            @if($order->action == "Delivery")
                            <li>Address: {{ $order->address }}</li>
                            <li>Contact: {{ $order->contact }}</li>
                            @else
                            <li>Pax: {{ $order->pax }}</li>
                            @endif
                            <li>Served by: {{ $order->waiter->full_name }}</li>
                        </ul>
                    </a>
                </div>

                @can('manage')
                    <livewire:order.modal.discount :order="$order" key="discount-{{ $order }}" />
                    <div class="flex flex-row mt-2 items-center space-x-2">
                        <button
                            class="text-xs py-1 px-2 rounded-md text-white bg-green-500"
                            wire:click="$emitTo('order.modal.discount', '{{ "openDiscount.{$order->id}" }}' )">{{ __('Discount') }}</button>

                    </div>
                    <div class=" flex items-center mt-2">

                        <div class="text-xs">

                            <input type="checkbox" class="rounded" id="service_charge{{ $order->id }}" value=1 {{ !$order->enable_tip ? 'checked' : '' }}  wire:model="enableServiceCharge">
                            <label for="service_charge{{ $order->id }}" class="text-gray-500" >Disable Service Charge</label>

                        </div>
                    </div>

                @endcan

                @else
                Empty
                @endif

            </div>
            <div class="flex items-center w-8">
                @if(!empty($order))
                <div wire:loading>
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div wire:loading.remove>

                    <button type="button" class="w-5" wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $order->id }}, 1, 'order')">
                        <i class="fa fa-trash {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>
        <div class="rounded-b-lg text-center text-sm font-bold">
            <div class="flex items-end">
                <div class="w-full">
                    <livewire:order.modal.billing-type :billingType="$order->billing_type"
                        :order="$order" key="billing-{{ $order->id }}" />
                </div>
                <button class="w-full {{ count($order->orderReceipts) > 0 ? 'text-red-500' : 'text-gray-300' }} font-bold" type="button" {{ count($order->orderReceipts) > 0 ? '' : 'disabled' }}
                    x-on:click="window.livewire.emitTo('order.checkout', 'checkOut', {{ $order->id }})">
                    Check out
                </button>

            </div>

        </div>
    </div>
    <livewire:order.modal.discount key="discount-{{ $order->id }}" />
</div>

<script>
    function print(id){
        a = window.open('/print-bill/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
        a.screenX = 0;
        a.screenY = 0;
        a.document.title = "Print";
        a.focus();
        setTimeout(() => {
            a.close();
        }, 1000);
    };
</script>
