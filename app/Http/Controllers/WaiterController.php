<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class WaiterController extends Controller
{
    public function loginViaPasscode(Request $request)
    {
        $user = User::where('passcode', $request->passcode)->first();
        if (!$user) {
            return back()->withErrors([
                'passcode' => 'Incorrect passcode',
            ]);
        }
        $request->session()->regenerate();
        Auth::login($user);
        return redirect('/waiter-order');
    }

    public function waiterOrder()
    {
        $tables = Table::query();


        if (Auth::user()->hasRole('waiter')) {
            //
            $table_ids = Auth::user()->assignTables->pluck('id');
            $tables->whereIn('id', $table_ids);
        }

        $tables = $tables->get();
        return view('order', compact('tables'));
    }

    public function adminCode(Request $request)
    {
        $user = User::where('passcode', $request->passcode)->first();
        if ($user->role->name == "admin" || $user->role->name == "operation") {
            return response()->json([
                'success' => 'Success',
            ]);
        } else {
            return response()->json([
                'error' => 'Incorrect code',
            ]);
        }
    }

    public function dashboard()
    {
        return view('waiter.dashboard');
    }

    public function printWaiterReport($waiter, $startDate, $endDate = null)
    {
        try {

            $orders = Order::with(['orderDetails', 'customOrderDetails'])
                ->where('waiter_id', $waiter);

            if($endDate)
            {
                $orders->whereRaw('DATE(orders.created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }
            else{
                $orders->whereDate('orders.created_at', $this->date);
            }

            $items = [];
            foreach($orders->get() as $order){
                foreach ($order->orderDetails as $i) {
                    $items[] = new receiptItem($i->dish->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
                }

                foreach ($order->customOrderDetails as $i) {
                    $items[] = new receiptItem($i->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
                }
            }

            // foreach ($order->orderDetails as $i) {
            //     $items[] = new receiptItem($i->dish->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
            // }

            // foreach ($order->customOrderDetails as $i) {
            //     $items[] = new receiptItem($i->name." X ".$i->pcs, number_format($i->price, 2, '.', ','));
            // }

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


            $printer->feed(3);

            $printer->cut();

            /* Close printer */
            $printer->close();


        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
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
