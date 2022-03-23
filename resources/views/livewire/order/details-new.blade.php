<div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="pt-2" x-data="orders()" x-init="init">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center flex-col sm:flex-row mt-3">
                <div class="flex flex-col w-full">
                    <div class="grid grid-cols-3 md:grid-cols-5">

                        @foreach ($categories as $category)
                            <x-menu-card :img="asset($category->icon)" :category="$category->name"
                                @click="selectCategory( {{ $category->id }} )"
                                ::class=" selectedCategory == {{ $category->id }} ? 'border-green-500' : '' " />
                        @endforeach

                        <x-menu-card :img=" asset('icons/Custom.png')" @click="addCustom" category="Custom" />
                    </div>
                    <div x-show="isLoading">
                        <div class="flex justify-center items-center mt-3 w-full">
                            <i class="fas fa-circle-notch text-red-700 text-3xl fa-spin"></i>
                        </div>
                    </div>
                    <div class="mt-3 h-96 w-full overflow-y-auto border" x-show="!isLoading">
                        <template x-for="(dish, index) in categoryDishes" :key="index">
                            <div class="flex border justify-between items-center py-3 pl-2 pr-3 text-xs lg:text-sm">
                                <div class="flex items-center">
                                    <button type="button" @click="decrement(index)" ><i class="fa fa-minus"></i></button>
                                    <x-input type="number" min="1" class="w-12 mx-2" x-model="dish.quantity" readonly/>
                                    <button type="button" @click="increment(index)"><i class="fa fa-plus"></i></button>
                                </div>
                                <div class="flex justify-between w-1/2">
                                    <div class="flex flex-col">
                                        <span x-text="dish.name">
                                        </span>
                                        <span class="text-xs text-green-900" x-text="dish.add_on ? 'with side dishes' : ''">
                                        </span>
                                    </div>
                                    <div x-text="numberWithCommas(dish.price)">
                                    </div>
                                </div>
                                <div>
                                    <button
                                        @click="addDish(dish)"
                                        class="text-white p-2 rounded ml-3 w-10"
                                        :class="!dish.status ? 'bg-gray-300' : 'bg-green-500 hover:bg-green-700'">
                                            <i class="fas fa-plus text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="sm:w-2/5 sm:mt-0 mt-3">
                    <div class="mx-2 flex flex-col">
                        <div class="mb-2 flex-none">
                            <div class="my-3">
                                <button type="button" @click="reviewOrder"
                                    class="bg-green-500 hover:bg-green-700 py-3 w-full text-center rounded-lg text-white">
                                    Proceed</button>
                            </div>
                            <div class="text-lg font-bold flex flex-row justify-between">
                                <span>
                                    Total:
                                </span>
                                <div>
                                    ₱ <span x-text="numberWithCommas(totalPrice)"></span>
                                </div>
                            </div>

                        </div>
                        <div class="overflow-y-auto border rounded-lg p-1.5 w-full flex-grow">
                            @if($order)
                                @foreach ($oldOrders as $i => $item)
                                    <div class="flex justify-around mb-5 xl:text-sm text-xs" wire:model.defer="oldOrders.{{ $i }}">
                                        <button type="button" class="w-5"
                                            wire:click.prevent="$emitTo('order.modal.cancel', 'cancelDish', {{ $item->id }} , 0)" >
                                            <i class="fa fa-minus-circle {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                                        </button>
                                        <div class="flex flex-col w-28">
                                            <div class="flex flex-col">
                                                <span>
                                                    {{ $item->dish->name }}
                                                </span>
                                                <span class="text-xs">
                                                    <ul>
                                                        @foreach ($item->sideDishes as $side)
                                                            <li>with: {{ $side->dish->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </span>
                                                <span>
                                                    {{ $item->note ? "note: ".$item->note : '' }}
                                                </span>
                                            </div>
                                            <div>
                                                X{{ $item['pcs'] }}
                                            </div>
                                        </div>
                                        <div class="flex items-end">
                                            ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($oldCustomOrders as $i => $item)
                                    <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                        <button type="button" class="w-5">
                                            <i class="fa fa-minus-circle {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                                        </button>
                                        <div class="flex flex-col w-28">
                                            <div class="flex flex-col">
                                                <span>
                                                    {{ $item->name }}
                                                </span>
                                                <span class="text-xs">
                                                    {{ "Desc: ".$item->description }}
                                                </span>
                                            </div>
                                            <div>
                                                X{{ $item['pcs'] }}
                                            </div>
                                        </div>
                                        <div class="flex items-end">
                                            ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <template x-for="(orderedDish, index) in orderedDishes" :key="index">
                                <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                    <button type="button" class="w-5" @click="removeDish(index)">
                                        <i class="fa fa-minus-circle text-red-500"></i>
                                    </button>
                                    <div class="flex flex-col w-28" >
                                        <div class="flex flex-col">
                                            <span x-text="orderedDish.name"></span>

                                            <div class="text-xs">
                                                <template x-if="orderedDish.sideDishes">
                                                    <ul>
                                                        <template x-for="side in orderedDish.sideDishes">
                                                            <li>with: <span class="text-xs" x-text="side.name"></span></li>
                                                        </template>
                                                    </ul>
                                                </template>

                                                <div>
                                                    <span x-text="orderedDish.desc"></span>
                                                </div>
                                                <div x-show="orderedDish.note != ''">
                                                    Note: "<span x-text="orderedDish.note"></span>"
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            X <span x-text="orderedDish.quantity"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        ₱ <span x-text="numberWithCommas(orderedDish.price * orderedDish.quantity)"></span>
                                    </div>
                                </div>
                            </template>

                            <template x-for="(cDish, index) in customDishes" :key="index">
                                <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                    <button type="button" class="w-5" @click="removeCustom(index)">
                                        <i class="fa fa-minus-circle text-red-500"></i>
                                    </button>
                                    <div class="flex flex-col w-28" >
                                        <div class="flex flex-col">
                                            <div>
                                                <span x-text="cDish.name"></span>
                                            </div>
                                            <div class="text-xs">
                                                <div>
                                                    Desc: <span x-text="cDish.description"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            X <span x-text="cDish.pcs"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        ₱ <span x-text="numberWithCommas(cDish.price_per_piece * cDish.pcs)"></span>
                                    </div>
                                </div>
                            </template>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div x-show="customModal" x-cloak>
            <x-modal>
                <x-slot name="header">
                    Custom Order
                </x-slot>

                <template x-for="(error, index) in errors" :key="`custom` + index">
                    <span x-text="error" class="text-red-500 text-xs text-center"></span>
                </template>

                <div class="flex flex-col px-4">
                    <x-label for="customDish">{{ __('Dish Name*') }}</x-label>
                    <x-input type="text" class="w-full" id="customDish" x-model="customDish" required />

                </div>
                <div class="flex flex-col px-4">
                    <x-label for="customDescription">{{ __('Dish Description*') }}</x-label>
                    <x-textarea type="text" class="w-full" id="customDescription" x-model="customDesc"
                        required />

                </div>
                <div class="px-4">
                    <x-label for="type" :value="__('Dish Type*')"></x-label>
                    <x-select id="type" class="block mt-1 w-full font-medium text-sm" x-model="customType">
                        <option selected>Select Type</option>
                        <option value="foods">Foods</option>
                        <option value="drinks">Drinks</option>
                        <option value="alcoholic">Alcoholic</option>
                    </x-select>

                </div>
                <div class="flex flex-col px-4">
                    <x-label for="customPrice">{{ __('Dish Price*') }}</x-label>
                    <x-input type="number" class="w-full" id="customPrice" x-model="customPrice" required />

                </div>
                <div class="flex flex-col px-4">
                    <x-label for="customPcs">{{ __('Dish Quantity*') }}</x-label>
                    <x-input type="number" class="w-full" id="customPcs" x-model="customPcs" required />

                </div>

                <x-slot name="buttons">
                    <button type="button" @click="confirmCustom"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Add
                    </button>
                    <button type="button" @click="cancelCustom"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </x-slot>
            </x-modal>
        </div>

        <div x-show="addOnModal" x-cloak>
            <x-modal>
                <x-slot name="header">
                    <span x-text="selectedDish.name + ' x ' +selectedDish.quantity" />

                </x-slot>
                <div class="px-4 pb-4 sm:p-6 sm:pb-4 flex flex-col">
                    <span class="text-base font-medium">Add Note</span>
                    <x-textarea class="w-full" x-model="note"></x-textarea>
                </div>
                <div x-show="selectedDish['add_on']">

                    <div class="flex flex-col px-4">
                        <span class="text-base font-medium">Choose two side dishes</span>
                        <span x-text="errors.add_on" class="text-red-500 text-xs"></span>
                        @foreach ($sideDishes as $i => $addon)
                            <div class="flex">
                                <input class="mr-2" type="checkbox" id="addon{{ $addon->id }}" value="{{ json_encode($addon) }}" x-model="selectedAddOns"  />
                                <x-label for="addon{{ $addon->id }}" :value="$addon->name" />
                            </div>
                        @endforeach
                    </div>

                </div>
                <x-slot name="buttons">
                    <button type="button" @click="confirmDish"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Add
                    </button>
                    <button type="button" @click="cancelAddOn"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </x-slot>
            </x-modal>
        </div>

        <div x-show="reviewModal" x-cloak>
            <x-large-modal>
                <x-slot name="header">
                    ORDER REVIEW
                </x-slot>

                <div class="w-full mt-2 px-5">
                    <template x-for="(orderedDish, index) in orderedDishes" :key="'review' + index">
                        <div class="flex justify-between text-sm w-full">
                            <div class="flex flex-col">
                                <div class="flex flex-col">
                                    <span x-text="orderedDish.name"></span>

                                </div>
                                <div class="ml-2">
                                    X <span x-text="orderedDish.quantity"></span>
                                </div>
                            </div>
                            <div class="flex items-end">
                                ₱ <span x-text="numberWithCommas(orderedDish.price * orderedDish.quantity)"></span>
                            </div>
                        </div>
                    </template>
                    <template x-for="(cDish, index) in customDishes" :key="'custom' + index">
                        <div class="flex justify-between text-sm w-full">
                            <div class="flex flex-col">
                                <div class="flex flex-col">
                                    <span x-text="cDish.name"></span>

                                </div>
                                <div class="ml-2">
                                    X <span x-text="cDish.pcs"></span>
                                </div>
                            </div>
                            <div class="flex items-end">
                                ₱ <span x-text="numberWithCommas(cDish.price_per_piece * cDish.pcs)"></span>
                            </div>
                        </div>
                    </template>
                    <div class="text-center text-sm" x-show="customDishes.length < 1 && orderedDishes.length < 1">
                        No order Yet
                    </div>

                </div>

                <x-slot name="footer">
                    <span class="text-red-500 text-xs text-center" x-text="errors.order"></span>
                    <div class="font-bold flex flex-row justify-between mb-2 text-sm">
                        <span>
                            Total:
                        </span>
                        <div>
                            ₱ <span x-text="numberWithCommas(totalPrice)"></span>
                        </div>
                    </div>
                    <div class="font-bold flex flex-row justify-between items-center mb-2 text-sm">
                        <span>
                            Pax:
                        </span>
                        <div class="flex flex-col">
                            <x-input class="text-right h-8" type="number" x-model="pax"></x-input>
                        </div>
                    </div>
                    @if($action == 'Delivery')
                    <div class="font-bold flex flex-row justify-between items-center mb-2 text-sm">
                        <span>
                            Address:
                        </span>
                        <div class="flex flex-col">
                        </div>
                    </div>
                    <div class="font-bold flex flex-row justify-between items-center mb-2 text-sm">
                        <span>
                            Contact:
                        </span>
                        <div class="flex flex-col">
                        </div>
                    </div>
                    @endif
                    <button type="button" :disabled="confirmedOrder" @click="confirmOrder" :class="confirmedOrder ? 'bg-green-900 cursor-wait' : ' bg-green-500 hover:bg-green-700'"
                        class="mt-3 py-2 w-full text-center rounded-lg text-white text-sm">
                        <div class="mr-2" x-show="confirmedOrder">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                        <div x-show="!confirmedOrder">

                            Place Order on {{ $table->name ?? $action }}
                        </div>
                    </button>
                    <button type="button" @click="cancelReview" :disabled="confirmedOrder" :class="confirmedOrder ? 'bg-red-900 cursor-wait' : 'bg-red-500 hover:bg-red-700'"
                        class="mt-3  py-2 w-full text-center rounded-lg text-white text-sm">
                        Close
                    </button>
                </x-slot>
            </x-large-modal>
        </div>

    </div>

    @livewire('order.modal.cancel');

</div>

<script>
    function orders() {

        return {
            selectedCategory : @entangle('selectedCategory').defer,
            categories : @entangle('categories').defer,
            dishes : @entangle('dishes').defer,
            totalPrice : @entangle('totalPrice').defer,
            pax: @entangle('pax').defer,
            orderedDishes: @entangle('orderedDishes').defer,
            customDishes: @entangle('customDishes').defer,
            address: @entangle('address').defer,
            contact: @entangle('contact').defer,
            addOnModal : false,
            reviewModal : false,
            customModal : false,
            customDish : '',
            customType : '',
            customDesc : '',
            customPrice : 0,
            customPcs : 1,
            confirmedOrder : false,
            isLoading : true,
            selectedAddOns : [],
            categoryDishes : [],
            selectedDish: [],
            note : '',
            errors : [],
            selectCategory(val) {
                this.selectedCategory = val
                this.categoryDishes = this.dishes.filter( (d) => d.category_id == this.selectedCategory  )
                this.categoryDishes.forEach(dish => {
                    dish['quantity'] = 1
                });
            },
            increment(id){
                this.categoryDishes[id].quantity++
            },
            decrement(id){
                if (this.categoryDishes[id].quantity > 1)
                    this.categoryDishes[id].quantity--
            },
            init(){
                this.categoryDishes = this.dishes.filter( (d) => d.category_id == this.selectedCategory  )
                this.isLoading = false
                this.addOnModal = false
                this.reviewModal = false
            },
            addDish(d){
                this.addOnModal = true
                dish = convertToJSON(d)
                this.selectedDish = dish
            },
            confirmDish(){
                var same = false
                var addOns = []
                this.selectedDish['note'] = this.note

                if(this.selectedDish['add_on']) {
                    if( this.selectedAddOns.length == 2 ) {

                        this.selectedAddOns.forEach( (addOn, index) => {
                            parsed = JSON.parse(addOn)
                            try{
                                var a = {}
                                a['id'] = parsed['id']
                                a['name'] = parsed['name']
                                addOns.push(a)


                            }catch(err){
                                console.error(err)
                            }
                        })
                        this.selectedDish['sideDishes'] = addOns

                        this.selectedAddOns = []

                    }else{
                        this.errors['add_on'] = "You must select 2 side dishes"
                        return
                    }
                }

                this.orderedDishes.forEach( (item, index, arr) => {
                    sideDishesCount = 0
                    parsed = convertToJSON(item)

                    if( this.selectedDish['id'] == parsed['id'] && this.selectedDish['note'] == parsed['note'] ) {
                        console.log(parsed['sideDishes'])
                        if (parsed['sideDishes'] != null) {

                            if(parsed['sideDishes'].length > 0 ) {

                                parsed['sideDishes'].forEach( (side, index) => {
                                    console.log(side)

                                    for(x of this.selectedDish['sideDishes']) {
                                        console.log(x)
                                        if(side['id'] == x['id']) {
                                            sideDishesCount++
                                        }
                                    }

                                })
                            }
                            console.log(sideDishesCount)
                            if(sideDishesCount == 2 ) {

                                arr[index]['quantity'] += dish['quantity']
                                same = true
                                return false
                            }

                        }
                        else
                        {
                            arr[index]['quantity'] += dish['quantity']
                            same = true
                        }


                    }

                })
                console.log(this.selectedDish)
                if(!same) {

                    this.orderedDishes.push(convertToJSON(this.selectedDish))
                }

                this.totalPrice += this.selectedDish['price'] * this.selectedDish['quantity']
                this.selectedDish = false
                this.addOnModal = false
                this.note = ''
                this.errors = []

            },
            addCustom(){
                this.customModal = true
                this.customDish = ''
                this.customDesc = ''
                this.customType = ''
                this.customPrice = 0
                this.customPcs = 1
            },
            confirmCustom(){
                var errorCustom = 0
                if(this.customDish == '')
                {
                    this.errors['name'] = 'Name is required'
                    errorCustom += 1
                }

                if(this.customType == '')
                {
                    this.errors['type'] = 'Type is required'
                    errorCustom += 1
                }

                if(this.customDesc == '')
                {
                    this.errors['description'] = 'Description is required'
                    errorCustom += 1
                }

                if(this.customPrice < 1)
                {
                    this.errors['price'] = 'Price is required'
                    errorCustom += 1
                }

                if(this.customPcs < 1)
                {
                    this.errors['quantity'] = 'Quantity is required'
                    errorCustom += 1
                }

                if(errorCustom > 0)
                {
                    console.log(Object.values(this.errors))
                    this.errors = Object.values(this.errors)
                    return
                }

                this.customDishes.push({
                    'name' : this.customDish,
                    'pcs' : this.customPcs,
                    'description' : this.customDesc,
                    'price' : (this.customPrice * this.customPcs),
                    'price_per_piece' : this.customPrice,
                    'type' : this.customType,
                    'printed' : 0,
                })
                this.totalPrice += this.customPrice * this.customPcs

                this.cancelCustom()
            },
            cancelCustom(){
                this.customModal = false
                this.customDish = ''
                this.customDesc = ''
                this.customType = ''
                this.customPrice = 0
                this.customPcs = 1
                this.errors = []
            },
            cancelAddOn(){
                this.addOnModal = false
                this.selectedAddOns = []
            },
            removeDish(index){
                dish = convertToJSON(this.orderedDishes[index])
                this.totalPrice -= dish['price'] * dish['quantity']
                this.orderedDishes.splice(index, 1)
            },
            removeCustom(index){
                custom = this.customDishes[index]
                this.totalPrice -= custom.price
                this.customDishes.splice(index, 1)
            },
            reviewOrder() {
                this.reviewModal = true
            },
            cancelReview() {
                this.errors = []
                this.reviewModal = false
            },
            confirmOrder() {

                if(this.orderedDishes.length < 1 && this.customDishes.length < 1) {
                    this.errors['order'] = "Please add order"
                    return
                }

                if (this.pax < 1) {

                    this.errors['order'] = "Need more pax"
                    return
                }

                this.confirmedOrder = true
                Livewire.emit('createOrder')
            },

        }
    }

    function numberWithCommas(x) {
        return x.toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    function convertToJSON(x) {
        return JSON.parse(JSON.stringify(x))
    }

    window.addEventListener('printOrder', event => {

        Livewire.emit('close');
        var id = event.detail.orderId;
        a = window.open('/print/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
        a.screenX = 0;
        a.screenY = 0;
        a.document.title = "Print";
        a.focus();
        setTimeout(() => {
            a.close();
            window.location.href = "{{ url('/waiter-order') }}";
        }, 1000);
    });
</script>
