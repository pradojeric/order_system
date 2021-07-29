<div>
    <div>
        @can('manage')
            <x-session-message />
        @endcan
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5 mt-5">
            @foreach ($tables as $table)

                <livewire:order.table :table="$table" :order="$table->order()" key="table-{{ $table->id }}" />

            @endforeach
        </div>
        <div class="mt-5">
            <div class="w-full shadow-lg rounded-lg">
                <div class="py-2 px-4 bg-blue-400 rounded-t-lg flex justify-between items-center">
                    <strong class="text-white"> {{ __('TAKE-OUT') }} </strong>
                    <div class="text-white">
                        <a href="{{ route('orders.create', ['action' => 'take_out']) }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5">
                        @foreach ($takeOuts as $order)

                            <livewire:order.other-table :order="$order" action="take_out" key="takeOut-{{ $order->id }}" />

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div class="w-full shadow-lg rounded-lg">
                <div class="py-2 px-4 bg-blue-400 rounded-t-lg flex justify-between items-center">
                    <strong class="text-white"> {{ __('DELIVERY') }} </strong>
                    <div class="text-white">
                        <a href="{{ route('orders.create', ['action' => 'delivery']) }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5">
                        @foreach ($deliveries as $order)

                            <livewire:order.other-table :order="$order" action="delivery" key="delivery-{{ $order->id }}" />

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
