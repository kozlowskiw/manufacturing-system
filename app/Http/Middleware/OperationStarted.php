<?php

namespace App\Http\Middleware;

use App\ProductRecord;
use Closure;
use Illuminate\Support\Facades\Auth;

class OperationStarted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Auth::id();

        $operation_started = ProductRecord::join('work_records', 'product_records.work_record_id', '=', 'work_records.id' )
            ->select('product_records.*', 'work_records.user_id')
            ->whereNull('product_records.end_time')->where('work_records.user_id', '=', $user_id)
            ->latest('product_records.start_time')->get()->first();

        if (!is_null($operation_started) && is_null($operation_started->end_time)) {
            $request->session()->flash('danger', 'Najpierw zakończ wykonywanie operacji');
            return response()->view('product-record.edit', ['product_record' => $operation_started]);
        } else {
            return $next($request);
        }
    }
}
