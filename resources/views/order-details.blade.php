<x-waiter-layout>
    <x-slot name="navbar">
        @include('layouts.order-nav')
    </x-slot>
    @livewire('order.details', ['table' => $table, 'action' => $action])

</x-waiter-layout>
