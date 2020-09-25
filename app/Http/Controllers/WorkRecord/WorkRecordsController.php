<?php

namespace App\Http\Controllers\WorkRecord;

use App\Http\Controllers\Controller;
use App\User;
use App\WorkRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class WorkRecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();
        $id = Auth::id();
        $user_work_records = WorkRecord::where('user_id', $id)->orderBy('id', 'desc')->get();

        return view('work.index')->with([
            'user' => $user,
            'user_work_records' => $user_work_records
        ]);
    }

    public function handleWorkRecord(Request $request)
    {
        $current_time = now();
        $current_hour = date("G");
        if($current_hour<12) {
            $shift = '1';
        } elseif($current_hour>=12 && $current_hour<20) {
            $shift = '2';
        } else {
            $shift = '3';
        }

        $user_id = Auth::id();

        switch ($request->path()) {
            case 'praca/praca-start':
                if (Auth::user()->hasWorkStarted($user_id)){
                    $request->session()->flash('danger', 'Najpierw zakończ rozpoczętą pracę!');
                    return redirect()->route('ewidencja.praca.create');
                } else {
                    $work_record = WorkRecord::create([
                        'user_id' => $user = $user_id,
                        'declared_working_time' => $request['declared_working_time'],
                        'start_time' => $current_time,
                        'shift' => $shift
                    ]);

                    if($work_record->save()){
                        $request->session()->flash('success', 'Praca rozpoczęta!');
                    }else{
                        $request->session()->flash('danger', 'Wystąpił błąd.');
                    }
                }

                return redirect()->route('ewidencja.praca.create');

            case 'praca/praca-koniec':
                $latestStarted = WorkRecord::where('user_id', $user_id)->latest('start_time')->first();

                $actualWorkingTime = $latestStarted->start_time->diffInMinutes($latestStarted->end_time);

                $latestStarted->end_time = now();
                $latestStarted->actual_working_time = $actualWorkingTime;

                $latestStarted->save();

                $request->session()->flash('success', 'Zakończono pracę.');

                return redirect()->route('ewidencja.praca.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
