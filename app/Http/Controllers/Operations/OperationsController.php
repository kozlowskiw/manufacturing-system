<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $operations = Operation::all();

        return view('operation.index')->with(['operations'=>$operations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('operation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $operation = new Operation();

        $operation->code = $request->code;
        $operation->name = $request->name;

        try {
            $operation->save();
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                $request->session()->flash('danger', 'Operacja o podanym kodzie już istnieje');
                return back();
            }
        }

        $request->session()->flash('success', 'Pomyślnie utworzono operację!');
        return redirect()->route('operation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Operation $operation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Operation $operation)
    {
        if(Gate::denies('manage-resources')){
            return redirect(route('operation.index'));
        }

        return view('operation.edit')->with([
            'operation' => $operation
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Operation $operation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Operation $operation)
    {
        $operation->code = $request->code;
        $operation->name = $request->name;

        try {
            $operation->save();
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                $request->session()->flash('danger', 'Operacja o podanym kodzie już istnieje');
                return back();
            }
        }

        $request->session()->flash('success', 'Operacja ' . $operation->name . ' została zaktualizowana!');
        return redirect()->route('operation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Operation $operation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Operation $operation)
    {
        $operation->delete();

        $request->session()->flash('success', 'Operacja ' . $operation->name . ' została usunięta!');

        return redirect()->route('operation.index');
    }
}
