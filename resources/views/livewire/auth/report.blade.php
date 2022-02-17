<div>
    <div x-data="setup()" class="w-full">
        <div class="flex justify-between mx-6 py-2">
            <div class="flex text-xs space-x-3">
                <span>
                    {{ __('Report Type') }}
                </span>
                <div class="flex space-x-2">
                    <x-input type="radio" name="dateType" id="single" wire:model.lazy="dateType" value="single" />
                    <x-label for="single" :value="__('Single')" />
                </div>
                <div class="flex space-x-2">
                    <x-input type="radio" name="dateType" id="range" wire:model.lazy="dateType" value="range" />
                    <x-label for="range" :value="__('Range')" />
                </div>
            </div>
            <div class="flex space-x-3 items-center">
                @if($dateType == 'single')
                    <button wire:click="prevDate"><i class="fa fa-arrow-left"></i></button>
                    <x-input type="date" class="w-auto text-sm" wire:model="date" />
                    <button wire:click="nextDate"><i class="fa fa-arrow-right"></i></button>
                @endif
                @if($dateType == 'range')
                    <x-input type="date" class="w-auto text-sm" wire:model="date" />
                    <span>-</span>
                    <x-input type="date" class="w-auto text-sm" wire:model="date2" />
                @endif
            </div>
        </div>
        <ul class="flex justify-start items-center my-4 mx-6">
            <template x-for="(tab, index) in tabs" :key="index">
                <li class="cursor-pointer py-2 px-4 text-gray-500 border-b-8"
                    :class="activeTab===index ? 'text-green-500 border-green-500' : ''" @click="activeTab = index"
                    x-text="tab"></li>
            </template>
        </ul>

        <div class="w-full bg-white">
            <div class="flex flex-row items-center space-x-2 text-sm mb-3 mx-6" x-show="activeTab===0||activeTab===1">
                <span class="mr-2">{{ __('Order Type: ') }}</span>
                <x-input type="radio" wire:model="action" value="all" name="action" id="all" />
                <label for="all">{{ __('All') }}</label>
                <x-input type="radio" wire:model="action" value="Dine In" name="action" id="dine_in" />
                <label for="dine_in">{{ __('Dine In') }}</label>
                <x-input type="radio" wire:model="action" value="Take Out" name="action" id="take_out" />
                <label for="take_out">{{ __('Take Out') }}</label>
                <x-input type="radio" wire:model="action" value="Delivery" name="action" id="delivery" />
                <label for="delivery">{{ __('Delivery') }}</label>
            </div>
            <div x-show="activeTab===0" class="overflow-x-auto">
                <div class="flex justify-end mx-6 space-x-2 text-xs">
                    <span class="font-semibold">{{ __('Cash:') }}</span>
                    <span>
                        P {{ number_format($this->cash, 2, '.', ',') }}
                    </span>
                    <span class="font-semibold">{{ __('Credit Card:') }}</span>
                    <span>
                        P {{ number_format($this->creditCard, 2, '.', ',') }}
                    </span>
                    <span class="font-bold">{{ __('Total:') }}</span>
                    <span>
                        P {{ number_format($this->total, 2, '.', ',') }}
                    </span>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order #</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dishes</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pax</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waiter</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Discount
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cash
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Credit Card
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Change
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Action</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                    <ul class="list-disc">
                                        @foreach ($order->orderDishes() as $item)
                                        <li class="text-xs">{{ $item['dish_name'] }} ({{ $item['qty'] }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $order->pax }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $order->action }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $order->waiter->full_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ '₱ '. number_format($order->totalPriceWithServiceCharge(), 2, '.', ',') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ '₱ '. $order->discount_option }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ '₱ '. number_format($order->cash, 2, '.', ',') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $order->ref_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ₱ {{ number_format($order->change, 2, '.', ',') }}
                                </td>
                                <td class="px-6 py-4">
                                    <!-- <button onclick="event.preventDefault(); print({{ $order->id }})"> -->
                                    <button x-on:click="print({{$order->id}})">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-sm text-red-500 py-4">No records</td>
                            </tr>

                        @endforelse
                    </tbody>
                    @if($orders->count() > 0)
                    <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td class="text-center text-md text-gray-500 py-4">Subtotal</td>
                            <td colspan="5" class="text-right text-md text-gray-500 py-4 px-6">
                                <span>

                                    {{ "P ". number_format($orders->sum('total'), 2, '.',',') }}
                                </span>
                                <span class="font-bold">

                                    ({{ "P ". number_format($total, 2, '.',',') }})
                                </span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                <div class="mx-3">
                    {{ $orders->links() }}
                </div>
            </div>
            <div x-show="activeTab===1">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dish
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($dishes as $dish)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $dish->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dish->quantity }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="mx-3">
                    {{ $dishes->links() }}
                </div> --}}
            </div>
            <div x-show="activeTab===2">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dish
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($customDishes as $dish)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $dish->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $dish->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dish->pcs }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="mx-3">
                    {{ $customDishes->links() }}
                </div> --}}
            </div>
            <div x-show="activeTab===3">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waiter Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kitchen</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bar</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tip</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Number of errors</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="sr-only">Action</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($waiters as $waiter)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $waiter->full_name }}
                            <td class="text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                ₱ {{ $waiter->runInKitchen()}}
                            </td>
                            <td class="text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                ₱ {{ $waiter->runInBar() }}
                            </td>
                            <td class="text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                ₱ {{ $waiter->ordersBy() }}
                            </td>
                            <td class="text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                ₱ {{ $waiter->getTip() }}
                            </td>
                            <td class="text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                <ul>
                                    <li>Voided orders: {{ $waiter->trashedOrders() }}</li>
                                    <li>Voided ordered dishes: {{ $waiter->orderErrors() }}</li>
                                </ul>
                            </td>
                            <td class="text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                <button type="button"
                                    x-on:click="printPerWaiter({{$waiter->id}})">
                                <!-- onclick="event.preventDefault(); printPerWaiter({{ $waiter->id }})" > -->

                                    <i class="fa fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>



</div>

<script>
    // function print(id) {

    //     a = window.open('/print-po/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
    //     a.screenX = 0;
    //     a.screenY = 0;
    //     a.document.title = "Print";
    //     a.focus();
    //     setTimeout(() => {
    //         a.close();
    //     }, 1000);
    // }

    // function printPerWaiter(id)
    // {
    //     a = window.open('/print-waiter-report/'+id+'/{{ $date }}/{{ $date2 }}', 'myWin', 'left=50, top=50, width=400, height=800');
    //     a.screenX = 0;
    //     a.screenY = 0;
    //     a.document.title = "Print";
    //     a.focus();
    //     setTimeout(() => {
    //         //a.close();
    //     }, 1000);
    // }

    function setup() {
        return {
            activeTab: 0,
            tabs: [
                "Orders",
                "Dishes",
                "Custom Dishes",
                "Waiters",
            ],
            date1: @entangle('date'),
            date2: @entangle('date2'),
            print(id) {
                a = window.open('/print-po/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
                a.screenX = 0;
                a.screenY = 0;
                a.document.title = "Print";
                a.focus();
                setTimeout(() => {
                    a.close();
                }, 1000);
            },
            printPerWaiter(id)
            {
                a = window.open('/print-waiter-report/'+id+'/'+this.date1+'/'+this.date2, 'myWin', 'left=50, top=50, width=400, height=800');
                a.screenX = 0;
                a.screenY = 0;
                a.document.title = "Print";
                a.focus();
                setTimeout(() => {
                    a.close();
                }, 1000);
            },
        };
    };

</script>
