<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ChooseBuyer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $orderToday = Order::with(['details'])
            ->whereDate('date', Carbon::now())
            ->orderByDesc('updated_at')
            ->first();
        if (!$orderToday?->buyer_id) {
            return $next($request);

        }

        abort(403);
    }
}
