<x-waiter-layout>
    <x-slot name="navbar">
        @include('layouts.order-nav')
    </x-slot>
    @livewire('order.details', ['table' => $table, 'action' => $action, 'order' => $order])

</x-waiter-layout>
