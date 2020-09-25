<?php

namespace App\Http\Middleware;

use App\WorkRecord;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkStarted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = Auth::id();

        $work_started = WorkRecord::whereNull('end_time')->where('user_id', '=', $userId)->latest('start_time')->get()->first();

        if (!isset($work_started) || is_null($work_started)) {

            $request->session()->flash('warning', 'Najpierw rozpocznij pracę!');
            return redirect()->route('ewidencja.praca.create');
        } else {
            return $next($request);
        }
    }


}
