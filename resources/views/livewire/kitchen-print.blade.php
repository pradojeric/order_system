<div>
    <div wire:poll.1000ms>
        {{now()->format('l, F d, Y h:i:s a')}}
    </div>
    <div>
        Kitchen
    </div>
    <div>
            
        Order Number: {{ $order->order_number ?? "No Order" }}
    </div>
    <x-slot name="script">
        <script>

            Echo.channel('kitchenPrint')
                .listen('PrintKitchenEvent', (event) => {
                    a = window.open('/print-kitchen/'+event.order.id, 'myWin', 'left=50, top=50, width=400, height=800');
                    a.screenX = 0;
                    a.screenY = 0;
                    a.document.title = "Print";
                    a.focus();
                    setTimeout(() => {
                        a.close();
                    }, 1000);

                })
        </script>

    </x-slot>
</div>

