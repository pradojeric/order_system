<div>
    @if($isModalOpen)
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex-shrink-0 flex items-center justify-center mx-auto">
                        <!-- Heroicon name: outline/exclamation -->
                        {{ __('CUSTOM DISH') }}
                    </div>
                </div>
                <form wire:submit.prevent="addCustomDish" class="space-y-3">
                    <div class="flex flex-col px-4">
                        <x-label for="customDish">{{ __('Dish Name') }}</x-label>
                        <x-input type="text" class="w-full" wire:model="customDish" id="customDish" required />
                        @error('customDish') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col px-4">
                        <x-label for="customDescription">{{ __('Dish Description') }}</x-label>
                        <x-textarea type="text" class="w-full" wire:model="customDescription" id="customDescription"
                            required />
                        @error('customDescription') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="px-4">
                        <x-label for="type" :value="__('Dish Type')"></x-label>
                        <x-select id="type" class="block mt-1 w-full font-medium text-sm" wire:model="customType">
                            <option selected>Select Type</option>
                            <option value="foods">Foods</option>
                            <option value="drinks">Drinks</option>
                            <option value="alcoholic">Alcoholic</option>
                        </x-select>
                        @error('customType') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col px-4">
                        <x-label for="customPrice">{{ __('Dish Price') }}</x-label>
                        <x-input type="number" class="w-full" wire:model="customPrice" id="customPrice" required />
                        @error('customPrice') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col px-4">
                        <x-label for="customPcs">{{ __('Dish Quantity') }}</x-label>
                        <x-input type="number" class="w-full" wire:model="customPcs" id="customPcs" required />
                        @error('customPcs') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </form>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="addToDish"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Add
                    </button>
                    <button type="button" wire:click="close"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
