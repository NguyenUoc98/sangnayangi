<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Jobs\SendPostUpdated;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create()
    {
        $order = Auth::user()->orders()->whereDate('created_at', Carbon::now())->first();
        return view('orders.edit-add', compact('order'));
    }

    public function store(Request $request)
    {
        $description = $request->get('note', '');
        $foods       = $request->get('foods', []);
        if (count($foods)) {
            try {
                DB::transaction(function () use ($foods, $description) {
                    $order = Order::query()
                        ->firstOrCreate([
                            'date' => Carbon::now()->format('Y-m-d')
                        ]);

                    $orderDetail = OrderDetail::query()
                        ->updateOrCreate([
                            'order_id' => $order->id,
                            'user_id'  => Auth::id(),
                        ], [
                            'description' => $description,
                        ]);

                    $orderDetail->foods()->detach();
                    $orderDetail->foods()->attach($foods);

                }, 1);
                return redirect()->route('dashboard');

            } catch (\Exception $exception) {
                return redirect()->back()->with([
                    'type'    => 'error',
                    'message' => 'Đặt không thành công!',
                ]);
            }
        }

        return redirect()->back()->with([
            'type'    => 'error',
            'message' => 'Chưa chọn món',
        ]);
    }

}
