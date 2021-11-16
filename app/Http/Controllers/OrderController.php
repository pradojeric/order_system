<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Table;
use App\Models\Configuration;
use Carbon\Carbon;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            DB::beginTransaction();

            $date = now()->toDateTimeString();
            $foods = [];
            $drinks = [];
            $new = [];
            foreach ($order->orderDetails as $i) {
                echo $i->printed."<br>";
                if($i->printed == false){
                    $description = '';
                    if($i->isDrink()){

                        $drinks[] = new item($i->dish->name, $i->pcs, $description, $i->note);
                    }

                    if($i->isFood()){
                        $dishName = $i->dish->name;
                        if($i->sideDishes) {
                            foreach($i->sideDishes as $side){
                                $description .= "\n side: ".$side->dish->name;
                            }
                        }

                        $foods[] = new item($dishName, $i->pcs, $description, $i->note);
                    }

                    $new[] = $i->id;
                    $i->printed = true;
                    $i->save();
                }

            }
            $newc = [];
            foreach ($order->customOrderDetails as $c) {
                if($c->printed == false){
                    $itemName = $c->name;

                    if($c->isDrink()){
                        $drinks[] = new item($itemName, $c->pcs, $c->description);
                    }
                    if($c->isFood()){
                        $foods[] = new item($itemName, $c->pcs, $c->description);
                    }
                    $c->printed = true;
                    $c->save();
                    $newc[] = $c->id;
                }
            }


            $length = 60;

            if(count($foods) > 0) {

                // Enter the share name for your USB printer here
                //$connector1 = new WindowsPrintConnector("smb://L403-PC38/POS-58");
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

            DB::commit();

        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
            DB::rollback();
        }
    }

    public function printBill(Order $order)
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
            $config = Configuration::first();
            if($order->action == "Dine In")
                $config_tip = $config->tip.'%';
            else
                $config_tip = "";
            $totalPrice = new receiptItem('Subtotal' , number_format($order->totalPrice(), 2, '.', ','));
            $serviceCharge = new receiptItem('Service Charge '.$config_tip, number_format($order->serviceCharge(), 2, '.', ','));
            $discount = new receiptItem('Discount' , $order->discount_option);
            $totalDiscounted = new receiptItem('Total' , number_format($order->totalPriceWithServiceCharge(), 2, '.', ','));

            // Enter the share name for your USB printer here
            // $connector = new WindowsPrintConnector("POS-58");
            $connector = new WindowsPrintConnector("POS-58-BAR");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("SABINA\n");
            $printer->selectPrintMode();
            $printer->text("Leisure Coast Resort\n");
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
                $printer->text($discount->getAsString($length));
            }
            $printer->text($totalPrice->getAsString($length));
            $printer->text($serviceCharge->getAsString($length));
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text($totalDiscounted->getAsString());
            $printer->selectPrintMode();

            $printer->feed(3);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text($date . "\n");
            $printer->text("Server: " . $order->waiter->full_name . "\n");

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

            $config = Configuration::first();
            $cash = new receiptItem('Cash', number_format($order->cash, 2, '.', ','));
            $change = new receiptItem('Change', number_format($order->change, 2, '.', ','));
            $totalPrice = new receiptItem('Subtotal' , number_format($order->totalPrice(), 2, '.', ','));
            if($order->action == "Dine In")
                $config_tip = $config->tip.'%';
            else
                $config_tip = "";
            $serviceCharge = new receiptItem('Service Charge '.$config_tip, number_format($order->serviceCharge(), 2, '.', ','));
            $discount = new receiptItem('Discount' , $order->discount_option);
            $totalDiscounted = new receiptItem('Total' , number_format($order->totalPriceWithServiceCharge(),2, '.', ','));

            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("POS-58-BAR");
            // $connector = new WindowsPrintConnector("POS-58");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("SABINA\n");
            $printer->selectPrintMode();
            $printer->text("Leisure Coast Resort\n");
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
    private $note;

    public function __construct($name = '', $quantity = '', $description = '', $note = '')
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->note = $note;
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
        if($this->description != '' || $this->description != null)
            $left .= $this->description;
        if($this->note != '' || $this->note != null)
            $left .= "\n note: ".$this->note;
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
