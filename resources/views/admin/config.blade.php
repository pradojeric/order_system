<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-session-message />
                <div class="bg-white border-b border-gray-200 space-y-4 divide-y-2">
                    <div class="px-6 py-3">
                        <form action="/admin/order-number-update" method="post">
                            @csrf
                            @method('put')
                            <x-label for="order_no">{{ __('Edit Order Number') }}</x-label>
                            <x-input type="text" class="w-52" id="order_no" name="order_no"
                                :value="$config->order_no" />
                            <x-button class="ml-3">Edit</x-button>
                        </form>
                    </div>
                    <div class="px-6 py-3">
                        <form action="/admin/receipt-number-update" method="post">
                            @csrf
                            @method('put')
                            <x-label for="receipt_no">{{ __('Edit Receipt Number') }}</x-label>
                            <x-input type="text" class="w-52" id="receipt_no" name="receipt_no"
                                :value="$config->receipt_no" />
                            <x-button class="ml-3">Edit</x-button>
                        </form>
                    </div>
                    <div class="px-6 py-3">
                        <form action="/admin/tin-number-update" method="post">
                            @csrf
                            @method('put')
                            <x-label for="tin_no">{{ __('Edit TIN Number') }}</x-label>
                            <x-input type="text" class="w-52" id="tin_no" name="tin_no" :value="$config->tin_no" />
                            <x-button class="ml-3">Edit</x-button>
                        </form>
                    </div>
                    <div class="px-6 py-3">
                        <form action="/admin/tip-update" method="post">
                            @csrf
                            @method('put')
                            <x-label for="tip">{{ __('Edit tip in %') }}</x-label>
                            <x-input type="number" class="w-52" min="0" max="100" id="tip" name="tip"
                                :value="$config->tip" />
                            <x-button class="ml-3">Edit</x-button>
                        </form>
                    </div>
                    <div class="px-6 py-3">
                        <form action="/admin/take-out-charge-update" method="post">
                            @csrf
                            @method('put')
                            <x-label for="take_out_charge">{{ __('Edit take out charge in Php') }}</x-label>
                            <x-input type="number" class="w-52" min="0" max="100" id="take_out_charge" name="take_out_charge"
                                :value="$config->take_out_charge" />
                            <x-button class="ml-3">Edit</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
