<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 bg-white border-b border-gray-200">
                    <div class="px-6" x-data="setup()">

                        <div class="text-right">
                            <x-button type="button" wire:click="save()">Save Report</x-button>
                        </div>

                        <div class="flex justify-end mx-6 py-2">

                            <div class="flex space-x-3 items-center">
                                {{-- @if($dateType == 'single') --}}
                                    <button wire:click="prevDate"><i class="fa fa-arrow-left"></i></button>
                                    <x-input type="date" class="w-auto text-sm" wire:model="date" />
                                    <button wire:click="nextDate"><i class="fa fa-arrow-right"></i></button>
                                {{-- @endif --}}
                                {{-- @if($dateType == 'range')
                                    <x-input type="date" class="w-auto text-sm" wire:model="date" />
                                    <span>-</span>
                                    <x-input type="date" class="w-auto text-sm" wire:model="date2" />
                                @endif --}}
                            </div>
                        </div>

                        @error('remit')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        <div class="grid grid-flow-row grid-cols-2 gap-4">
                            @foreach ($overalls as $overall)
                                <div>
                                    <span class="uppercase">

                                        {{ $overall->name }}
                                    </span>
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-1/4">Item</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-1/4"></th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Quantity</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($overall->dishes as $dish)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $dish->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                        {{ $dish->properties }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                        {{ $dish->orderDetails->sum('pcs') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                        {{ '₱ '. number_format($dish->orderDetails->sum('price'), 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">Total</td>
                                                <td></td>
                                                <td></td>
                                                <td class="px-6 py-4 whitespace-nowrap font-bold text-lg text-right">{{'₱ '. number_format( $overall->dishes->sum(function ($dish) { return $dish->orderDetails->sum('price'); }) , 2, '.', ',') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            @endforeach

                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-full">Spoilage</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-20">Quantity</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <div>
                                                    <button type="button" class="bg-green-500 hover:bg-green-300 text-white rounded shadow-sm h-10 w-10 items-center" @click="addSpoilage">+</button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(spoil, index) in spoilages" :key="index">
                                            <tr>
                                                <td class="whitespace-nowrap text-sm text-gray-900">
                                                    <x-select x-model="spoil.dish" class="w-full block">
                                                        <option value=" " hidden>Select</option>
                                                        <template x-for="(dish, i) in dishes" :key="i">
                                                            <option :value="dish.name +` | `+dish.properties" x-text="dish.name + ` | ` + dish.properties"></option>
                                                        </template>
                                                    </x-select>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <x-input type="text" x-model="spoil.quantity" class=" w-20"></x-input>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <div>
                                                        <button type="button" class="bg-red-500 hover:bg-red-300 text-white rounded shadow-sm h-10 w-10 items-center" @click="removeSpoilage(index)">-</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-2">
                            @foreach ($overalls as $overall)
                                <div class="mb-1 flex justify-between w-1/2 px-3">
                                    <div>
                                        {{ $overall->name }}
                                    </div>
                                    <div class='flex justify-between w-1/3'>
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            {{number_format( $overall->dishes->sum(function ($dish) { return $dish->orderDetails->sum('price'); }) , 2, '.', ',') }}
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            <div class="w-1/2">
                                <hr>
                            </div>
                            <div class="flex justify-between w-1/2 px-3 font-bold mb-1">
                                <div>
                                    Total Sales
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        {{
                                            number_format( $total, 2, '.', ',')
                                        }}
                                    </div>
                                </div>
                            </div>

                            @foreach ($unpaids as $unpaid)
                                <div class="flex items-center justify-between w-1/2 px-3 bg-yellow-200">
                                    <div>
                                        {{ $unpaid->full_name }} {{ $unpaid->by ? "care off {$unpaid->by}" : "" }}
                                    </div>
                                    <div class="flex justify-between w-1/3">
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            {{ number_format($unpaid->total, 2, '.', ',') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="w-1/2 my-1">
                                <hr>
                            </div>
                            <div class="flex items-center justify-between w-1/2 px-3 my-1">

                                <div>
                                    To Remit
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <x-input type="text" class="text-xs text-right" x-model.number.lazy="remit"></x-input>
                                    </div>
                                </div>
                            </div>

                            @foreach ($latePayments as $late)
                                <div class="flex items-center justify-between w-1/2 px-3">
                                    <div>
                                        {{ $late->full_name }} {{ $late->by ? "care off {$late->by}" : "" }}  ({{$late->paid_on->format('M d')}})
                                    </div>
                                    <div class="flex justify-between w-1/3">
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            {{ number_format($late->total, 2, '.', ',') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="w-1/2 my-1">
                                <hr>
                            </div>
                            <div class="flex items-center justify-between w-1/2 px-3">

                                <div>
                                    Total Remittance
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="numberWithCommas(getTotalRemittance())"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function setup() {
        return {

            date1: @entangle('date'),
            date2: @entangle('date2'),
            spoilages: @entangle('spoilages').defer,
            dishes: @entangle('dishes').defer,
            totalRemittance: @entangle('totalRemittance').defer,
            remit: @entangle('remit'),
            total: {{ $total }},
            unpaid: {{ $unpaids->sum('total') }},
            addSpoilage() {
                this.spoilages.push({
                    'dish' : '',
                    'quantity': 1,
                })
            },
            removeSpoilage(index) {
                this.spoilages.splice(index, 1)
            },
            getTotalRemittance() {
                this.totalRemittance = this.unpaid + this.remit
                return this.totalRemittance
            },
        };
    };

    function numberWithCommas(x) {
        return x.toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

</script>
