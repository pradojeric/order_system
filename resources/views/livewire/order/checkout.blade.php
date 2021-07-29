<div>
    @if($isModalOpen)
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="absolute z-40 inset-0" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-data>
        <div class="flex items-start justify-center h-screen pt-4 px-4 text-center sm:block sm:p-0">
            <!--
            Background overlay, show/hide based on modal state.

            Entering: "ease-out duration-300"
              From: "opacity-0"
              To: "opacity-100"
            Leaving: "ease-in duration-200"
              From: "opacity-100"
              To: "opacity-0"
          -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!--
            Modal panel, show/hide based on modal state.

            Entering: "ease-out duration-300"
              From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
              From: "opacity-100 translate-y-0 sm:scale-100"
              To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          -->
            <div
                class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-96">
                <div class="flex flex-col justify-between h-screen">
                    <div class="flex-shrink flex bg-white py-3">
                        <div class="flex-shrink-0 flex flex-col items-start justify-center px-5">
                            <!-- Heroicon name: outline/exclamation -->
                            <div>
                                {{ $table->name ?? '' }}
                            </div>
                            <div>
                                Order # {{ $orderNumber }}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-grow overflow-y-auto border p-1.5">
                        <div class="w-full">
                            @foreach ($orderDetails as $i => $item)
                            <div class="flex justify-between mb-1 text-sm w-full px-3">
                                <div class="flex flex-col w-52">
                                    <div class="flex flex-col">
                                        <span>
                                            {{ $item['name'] }}
                                        </span>
                                        <span class="text-xs">
                                            {{ array_key_exists('side_dish', $item) && $item['side_dish'] ? 'with '.$item['side_dish'] : '' }}
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
                            @endforeach

                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col flex-shrink justify-center">

                        <div class="text-sm font-bold flex flex-row justify-between mb-2">
                            <span>
                                Total:
                            </span>
                            <span>
                                ₱ {{number_format( $totalPrice, 2, '.', ',') }}
                            </span>
                        </div>
                        @if($enableDiscount)
                        <!-- if Enable Discount -->
                        <div class="text-sm font-bold flex flex-row justify-between mb-2">
                            <span>
                                Discount type:
                            </span>
                            <span>
                                {{ $discountType }}
                            </span>
                        </div>
                        <div class="text-sm font-bold flex flex-row justify-between mb-2">
                            <span>
                                Discount:
                            </span>
                            <span>
                                {{ $discountType == 'percent' ? "$discount%" : "₱ ".number_format( $discount, 2, '.', ',') }}
                            </span>
                        </div>
                        @endif
                        <!-- End Enable Discount -->

                        <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                            <span>
                                Payment Type:
                            </span>
                            <div class="flex space-x-2">
                                <div class="flex">
                                    <x-input type="radio" name="paymentType" wire:model.lazy="paymentType" id="cash" value="cash" />
                                    <x-label for="cash" :value="__('Cash')" />
                                </div>
                                <div class="flex">
                                    <x-input type="radio" name="paymentType" wire:model.lazy="paymentType" id="check" value="check" />
                                    <x-label for="check" :value="__('Check')" />
                                </div>
                            </div>
                        </div>

                        @if($paymentType == 'check')
                        <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                            <span>
                                Ref Number:
                            </span>
                            <div class="flex flex-col">
                                <x-input class="text-right h-8" wire:model="refNo"
                                    type="text" />
                                @error('refNo')
                                <span class="text-xs text-red-500 text-right">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                            <span>
                                Cash:
                            </span>
                            <div class="flex flex-col">
                                <x-input class="text-right h-8" wire:model.defer="cash" wire:keyup="computeChange"
                                    type="number" />
                                @error('cash')
                                <span class="text-xs text-red-500 text-right">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-sm font-bold flex flex-row justify-between mb-2">
                            <span>
                                Change:
                            </span>
                            <span>₱ {{ $change ?? '0' }} </span>
                        </div>

                        <button type="button" wire:click="confirmCheckOut" id="cOut" wire:loading.attr="disabled"
                            class="mt-3 bg-green-500 hover:bg-green-700 py-2 w-full text-center rounded-lg text-white text-sm">
                            <div wire:loading wire:target="confirmCheckOut" class="mr-2">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                            Check Out
                        </button>

                        <button type="button" wire:click="close"
                            class="mt-3 bg-red-500 hover:bg-red-700 py-2 w-full text-center rounded-lg text-white text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    window.addEventListener('printPO', event => {
        var button = document.getElementById('cOut');
        if(button != null) button.disabled = true;

        var id = event.detail.orderId;
        a = window.open('/print-po/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
        a.screenX = 0;
        a.screenY = 0;
        a.document.title = "Print";
        a.focus();
        setTimeout(() => {
            a.close();
        }, 1000);
    });
</script>
