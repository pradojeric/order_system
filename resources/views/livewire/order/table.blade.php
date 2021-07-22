<div>
    <div class="w-full shadow-lg rounded-lg flex flex-col flex-grow h-64 justify-between" x-data>
        <div
            class="flex flex-row items-center justify-between py-2 px-3 {{ $hasOrder ? 'bg-green-800' : 'bg-gray-300' }} rounded-t-lg">
            <strong class="text-white">
                {{ Auth::user()->assignTables->find($table->id)->pivot->table_name ?? $table->name }} ({{ $table->pax }} pax)
            </strong>
            <div class="text-white">
                <button class="mr-2" @if($hasOrder) x-on:click.prevent="print('{{ $table->order()->id }}')" @endif>
                    <i class="fa fa-print"></i>
                </button>
                <button
                    @click.prevent="window.livewire.emitTo('order.modal.edit-table', 'editTable', {{ $table->id }})">
                    <i class="fa fa-edit"></i>
                </button>
            </div>
        </div>
        <div class="px-2 h-full">
            <div class="flex h-full">
                <div class="w-64 p-2">
                    @if($hasOrder)
                    <div>
                        <a
                            href="{{ route('orders.show', ['action' => 'dine_in', 'tableId' => $table->id, 'order' => $table->order()]) }}">
                            <ul class="list-unstyled text-xs">
                                <li>Order # {{ $table->order()->order_number }}</li>
                                <li>Amount: ₱ {{number_format( $table->order()->totalPrice(), 2, '.', ',') }}</li>
                                <li>Pax: {{ $table->order()->pax }}</li>
                                <li>Served by: {{ $table->order()->waiter->full_name }}</li>
                            </ul>
                        </a>
                    </div>
                    @can('manage')
                    <div class="flex flex-row mt-2 items-center space-x-2">
                        <button
                            class="text-xs py-1 px-2 rounded-md text-white {{  !$enableDiscount ? 'bg-green-500 hover:bg-green-700' : 'bg-red-500 hover:bg-red-700' }}"
                            wire:click="activateDiscount">{{ !$enableDiscount ? 'Enable Discount' : 'Disable'}}</button>
                        @if ($enableDiscount)
                        <button class="text-xs py-1 px-2 rounded-md text-white bg-green-500 hover:bg-green-700"
                            wire:click="discountSave">Save</button>
                        @endif
                        @if($isSaved)
                        <i class="fa fa-check text-green-500"></i>
                        @endif
                    </div>

                    @if($enableDiscount)
                    <div class="flex flex-col mt-1 space-y-1">
                        <x-select class="h-8 text-xs" wire:model="discountType">
                            <option value="percent">{{ _('Percent') }}</option>
                            <option value="fixed">{{ _('Fixed') }}</option>
                        </x-select>
                        <x-input
                            class="text-right text-xs p-2 {{ $errors->get('discount') ? 'border border-red-500' : '' }}"
                            wire:model="discount" />
                    </div>
                    @endif
                    @endcan
                    @else
                    <a href="{{ route('orders.create', ['action' => 'dine_in', 'tableId' => $table->id]) }}">
                        <span class="text-xs">
                            Click here to select this table
                        </span>
                    </a>
                    @endif

                </div>
                <div class="flex items-center w-8">
                    @if($hasOrder)
                    <button type="button" class="w-5"
                        wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $table->order()->id }}, 1)">
                        <i class="fa fa-trash {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="rounded-b-lg p-2 text-center text-sm">
            @if ($hasOrder)
            <div class="flex items-end">
                <div class="w-full">
                    <livewire:order.modal.billing-type :billingType="$table->order()->billing_type" :order="$table->order()" key="billing-{{ $table->order()->id }}" />
                </div>
                <button type="button" class="w-full {{ count($table->order()->orderReceipts) > 0 ? 'text-red-500' : 'text-gray-300' }} font-bold" type="button" {{ count($table->order()->orderReceipts) > 0 ? '' : 'disabled' }}
                    wire:click.prevent="$emitTo('order.checkout', 'checkOut', {{ $table->order()->id }})">
                    Check out
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
