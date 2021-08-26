<x-waiter-layout>
    <x-slot name="navbar">
        @include('layouts.waiter-nav')
    </x-slot>
    <div class="pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-green-600">{{ __('DINE-IN') }}</h1>
            <livewire:order.service-type />
        </div>
    </div>
    @livewire('order.checkout')
    @livewire('order.modal.edit-table')
    @livewire('order.modal.transfer-table')
    @can('manage')
    @livewire('auth.passcode')
    @endcan
</x-waiter-layout>
