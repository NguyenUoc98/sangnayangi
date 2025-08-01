<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;

class PageController extends Controller
{
    public function dashboard()
    {
        $order = Order::with(['details', 'buyer'])
            ->whereDate('date', Carbon::now())
            ->orderByDesc('updated_at')
            ->first();
        return view('dashboard', compact('order'));
    }

    public function spinner()
    {
        return view('spinner');
    }
}
