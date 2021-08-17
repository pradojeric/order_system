<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Table;
use Carbon\Carbon;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function create($action, $tableId = null)
    {
        switch ($action) {
            case ('dine_in'):
                $action = 'Dine In';
                break;
            case ('take_out'):
                $action = 'Take Out';
                break;
            case ('delivery'):
                $action = 'Delivery';
                break;
        }

        $table = Table::find($tableId);
        return view('order-details', compact('action', 'table'));
    }

    public function show($action, Order $order, $tableId = null)
    {
        //
        switch ($action) {
            case ('dine_in'):
                $action = 'Dine In';
                break;
            case ('take_out'):
                $action = 'Take Out';
                break;
            case ('delivery'):
                $action = 'Delivery';
                break;
        }

        $table = Table::find($tableId);
        return view('show-order', compact('action', 'table', 'order'));
    }

    public function printReceipt(Order $order, $reprint = 0)
    {
        try {
            $date = now()->toDateTimeString();
            $foods = [];
            $drinks = [];
            foreach ($order->orderDetails as $i) {
                if($i->printed && $reprint == 0) continue;
                if($i->isDrink()){
                    $drinks[] = new item($i->dish->name, $i->pcs);
                }
                if($i->isFood()){
                    $dishName = $i->dish->name;
                    $description = $i->side_dishes ?  "side: ".$i->side_dishes['side_name'] : null;

                    $foods[] = new item($dishName, $i->pcs, $description);
                }
                $i->printed = true;
                $i->save();
            }

            foreach ($order->customOrderDetails as $i) {
                if($i->printed && $reprint == 0) continue;
                $itemName = $i->name;

                if($i->isDrink()){
                    $drinks[] = new item($itemName, $i->pcs, $i->description);
                }
                if($i->isFood()){
                    $foods[] = new item($itemName, $i->pcs, $i->description);
                }
                $i->printed = true;
                $i->save();
            }

            $length = 60;

            if(count($foods) > 0) {

                // Enter the share name for your USB printer here
                $connector1 = new WindowsPrintConnector("POS-58");

                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector1);
                $printer->initialize();
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setEmphasis(true);
                $printer->text("Kitchen\n");
                $printer->text("Order Number: " . $order->order_number . "\n");
                $printer->text($order->table()->name ?? '');
                $printer->setEmphasis(false);
                $printer->text("\n");
                $printer->text($order->action . "\n");
                $printer->text($date . "\n");
                $printer->text("Server: " . $order->waiter->full_name . "\n");
                $printer->feed(2);
                $printer->setJustification(Printer::JUSTIFY_LEFT);

                foreach ($foods as $o) {
                    $printer->text($o->getAsString($length));
                }
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text('---------------------');

                $printer->feed(4);

                $printer->cut();

                /* Close printer */
                $printer->close();
            }


            if(count($drinks) > 0 ){
                $connector2 = new WindowsPrintConnector("POS-58-BAR");

                $printer2 = new Printer($connector2);
                $printer2->setJustification(Printer::JUSTIFY_CENTER);
                $printer2->setEmphasis(true);
                $printer2->text("Bar\n");
                $printer2->text("Order Number: " . $order->order_number . "\n");
                $printer2->text($order->table()->name ?? '');
                $printer2->setEmphasis(false);
                $printer2->text("\n");
                $printer2->text($order->action . "\n");
                $printer2->text($date . "\n");
                $printer2->text("Server: " . $order->waiter->full_name . "\n");
                $printer2->feed(2);
                $printer2->setJustification(Printer::JUSTIFY_LEFT);
                foreach ($drinks as $o) {
                    $printer2->text($o->getAsString($length));
                }
                $printer2->setJustification(Printer::JUSTIFY_CENTER);
                $printer2->text('---------------------');

                $printer2->feed(4);

                $printer2->cut();

                /* Close printer */
                $printer2->close();
            }

        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

    public function printBill(Order $order)
    {
        try {

            $items = [];
            foreach ($order->orderDetails as $i) {
                $items[] = new receiptItem($i->dish->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            foreach ($order->customOrderDetails as $i) {
                $items[] = new receiptItem($i->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            $totalPrice = new receiptItem('Subtotal' , number_format($order->totalPriceWithServiceCharge(), 2, '.', ','));
            $serviceCharge = new receiptItem('Service', number_format($order->serviceCharge(), 2, '.', ','));
            $discount = new receiptItem('Discount' , $order->discount_option);
            $totalDiscounted = new receiptItem('Total' , number_format($order->totalPrice(),2, '.', ','));

            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("POS-58-BAR");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("SABINA\n");
            $printer->selectPrintMode();
            $printer->text('Bonuan, Dagupan, 2400 Pangasinan');
            $printer->setEmphasis(false);
            $printer->feed();

            /* Title of receipt */
            $length = 60;
            $printer->setEmphasis(true);
            $printer->text("BILL\n");
            $printer->setEmphasis(false);

            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->feed(2);

            /* Items */
            foreach ($items as $o) {
                $printer->text($o->getAsString($length));
            }
            $printer->feed();

            if($order->enable_discount)
            {
                $printer->text($totalPrice->getAsString($length));
                $printer->text($discount->getAsString($length));
            }

            $printer->text($serviceCharge->getAsString($length));
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text($totalDiscounted->getAsString());
            $printer->selectPrintMode();


            $printer->feed(3);

            $printer->cut();

            /* Close printer */
            $printer->close();


        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

    public function printPurchasOrder(Order $order)
    {
        try {
            $date = now()->toDateTimeString();
            $items = [];
            foreach ($order->orderDetails as $i) {
                $items[] = new receiptItem($i->dish->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            foreach ($order->customOrderDetails as $i) {
                $items[] = new receiptItem($i->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            $cash = new receiptItem('Cash', number_format($order->cash, 2, '.', ','));
            $change = new receiptItem('Change', number_format($order->change, 2, '.', ','));
            $totalPrice = new receiptItem('Subtotal' , number_format($order->totalPriceWithServiceCharge(), 2, '.', ','));
            $serviceCharge = new receiptItem('Service', number_format($order->serviceCharge(), 2, '.', ','));
            $discount = new receiptItem('Discount' , $order->discount_option);
            $totalDiscounted = new receiptItem('Total' , number_format($order->totalPrice(),2, '.', ','));

            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("POS-58-BAR");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("SABINA\n");
            $printer->selectPrintMode();
            $printer->text('Bonuan, Dagupan, 2400 Pangasinan');
            $printer->setEmphasis(false);
            $printer->feed();

            /* Title of receipt */
            $length = 60;
            $printer->setEmphasis(true);
            $printer->text("PURCHASE ORDER\n");
            $printer->setEmphasis(false);

            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->feed(2);

            /* Items */
            foreach ($items as $o) {
                $printer->text($o->getAsString($length));
            }
            $printer->feed();

            /* Tax and total */

            if($order->enable_discount)
            {
                $printer->text($totalPrice->getAsString($length));
                $printer->text($discount->getAsString($length));
            }

            $printer->text($serviceCharge->getAsString($length));
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text($totalDiscounted->getAsString());
            $printer->selectPrintMode();
            $printer->text($cash->getAsString($length));
            $printer->text($change->getAsString($length));

            $printer->feed(2);

            /* Footer */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("This is not the official receipt\n");
            $printer->feed();
            $printer->text("Server: " . $order->waiter->full_name . "\n");
            $printer->text("-----------------------\n");
            $printer->text($date . "\n");

            $printer->feed(3);

            $printer->cut();

            /* Close printer */
            $printer->close();


        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }
}

class item
{
    private $name;
    private $description;
    private $quantity;

    public function __construct($name = '', $quantity = '', $description = '')
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->description = $description;
    }

    public function getAsString($width = 48)
    {
        // $rightCols = 10;
        // $leftCols = $width - $rightCols;
        // if($this->description != '')
        // {
        //     $left = str_pad($this->name."\n   ".$this->description, $width);
        //     $rightCols *= 2;
        // }
        // else
        // {
        //     $left = str_pad($this->name , $leftCols);
        // }
        // $right = str_pad("X " . $this->quantity, $rightCols, ' ', STR_PAD_LEFT);
        // return "$left$right\n";
        $left = $this->quantity . " X  ".$this->name;
        if($this->description != null)
            $left .= "\n    ".$this->description;
        return "$left\n";
    }

    public function __toString()
    {
        return $this->getAsString();
    }
}

class receiptItem
{
    private $name;
    private $price;
    private $pesoSign;

    public function __construct($name = '', $price = '', $pesoSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->pesoSign = $pesoSign;
    }

    public function getAsString($width = 30)
    {
        $rightCols = 10;
        $leftCols = $width - $rightCols;
        if ($this->pesoSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);

        $sign = ($this->pesoSign ? 'P ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }

    public function __toString()
    {
        return $this->getAsString();
    }
}
