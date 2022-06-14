<div>
    <div>
        @can('manage')
            <x-session-message />
        @endcan

        <div class="mt-5">
            <div class="w-full shadow-lg rounded-lg">
                <div class="py-2 px-4 bg-blue-400 rounded-t-lg flex justify-between items-center">
                    <strong class="text-white"> {{ __('ORDERS') }} </strong>
                    <div class="text-white">
                        <a href="{{ route('orders.create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                        @foreach ($orders as $order)

                            <livewire:order.other-table :order="$order" key="takeOut-{{ $order->id }}" />

                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
