<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
