<?php

namespace App\Http\Controllers\WorkRecord;

use App\Operation;
use App\Product;
use App\ProductOperation;
use App\ProductRecord;
use App\Http\Controllers\Controller;
use App\WorkRecord;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        //pobranie wszystkich rekordów ewidencji elementów z dołączeniem kolumn user_id i start_time z ewidencji pracy dla zalogowanego użytkownika
        $user_product_records = ProductRecord::join('work_records', 'product_records.work_record_id', '=', 'work_records.id' )
            ->select('product_records.*', 'work_records.user_id', 'work_records.start_time as wr_start_time')
            ->where('work_records.user_id', '=', $user->id)
            ->get();

        //pobranie id wszystkich rekordów index_op_tech użytkownika
        $product_operations_ids = [];
        foreach ($user_product_records as $key => $user_product_record) {
            $product_operations_ids[$key] = $user_product_record->products_operations_id;
        }

        //pobranie rekordów index_op_tech wg id z dołączeniem nazw elementów i operacji
        $user_product_operations = [];
        foreach ($product_operations_ids as $key => $product_operations_id) {
            $user_product_operation = ProductOperation::join('products as p', 'product_operations.product_id', '=', 'p.id' )
                ->join('operations as o', 'product_operations.operation_id', '=', 'o.id' )
                ->select('product_operations.*', 'p.name as p_name', 'o.name as o_name')
                ->where('product_operations.id', '=', $product_operations_id)
                ->get();
            $user_product_operations[$key] = $user_product_operation[0];
        }

        $products = Product::all();
        $operations = Operation::all();

        //dodanie wyników do jednej tabeli, tak aby w widoku można było ich użyć przy pomocy pętli foreach
        $data_rows = [];

        foreach ($user_product_records as $key => $user_product_record) {
            $data_rows[$key]['pr_id'] = $user_product_record->id;
            $data_rows[$key]['quantity'] = $user_product_record->quantity;
            $data_rows[$key]['start_time'] = $user_product_record->start_time;
            $data_rows[$key]['end_time'] = $user_product_record->end_time;
            $data_rows[$key]['actual_working_time'] = $user_product_record->actual_working_time;
            $data_rows[$key]['wr_start_time'] = $user_product_record->wr_start_time;
        }

        foreach ($user_product_operations as $key => $user_product_operation) {
            $data_rows[$key]['po_id'] = $user_product_operation->id;
            $data_rows[$key]['p_name'] = $user_product_operation->p_name;
            $data_rows[$key]['o_name'] = $user_product_operation->o_name;
        }

        return view('product-record.index')->with([
            'user' => $user,
            'data_rows' => $data_rows,
            'user_product_records' => $user_product_records,
            'user_product_operations' => $user_product_operations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $products = Product::all()->toJson();
        $operations = Operation::all()->toJson();

        Storage::disk('public')->put('products.json', $products);
        Storage::disk('public')->put('operations.json', $operations);

        return response()->view('product-record/create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->missing('product')) {
            $request->session()->flash('danger', 'Nie wybrano produktu');
            return back();
        } elseif ($request->missing('operation')) {
            $request->session()->flash('danger', 'Nie wybrano operacji');
            return back();
        } else {
            $product_operation = ProductOperation::where([
                ['product_id', '=', $request->product],
                ['operation_id', '=', $request->operation]
            ])->first();

            $user = Auth::user();
            $work_record = WorkRecord::where([
                ['user_id', '=', $user->id],
                ['end_time', '=', null]
            ])->first();

            $product_record = new ProductRecord();

            $product_record->work_record_id = $work_record->id;
            $product_record->products_operations_id = $product_operation->id;
            $product_record->start_time = now();

            $operation = Operation::find($request->operation);
            $product = Product::find($request->product);

            $product_record->save();

            $request->session()->flash('success', 'Rozpoczęto operację ' . $operation->name . ' na elemencie ' . $product->name);

            return response()->view('product-record/edit', ['product_record' => $product_record]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductRecord  $element
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRecord $element)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductRecord $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRecord $id)
    {
        if (Auth::user()->hasRole('pracownik produkcji')) {
            $product_record = ProductRecord::whereNull('end_time')->where('user_id', '=', Auth::id())->latest('start_time')->get()->first();

            return response()->view('product-record/edit', ['product_record' => $product_record]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product_record = ProductRecord::find($id);

        $product_record->quantity = $request->quantity;
        $product_record->end_time = now();
        $product_record->actual_working_time = $product_record->start_time->diffInMinutes($product_record->end_itme);

        $product_record->save();

        $request->session()->flash('success', 'Zakończono pracę!');
        return redirect()->route('ewidencja.elementy.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductRecord  $element
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRecord $element)
    {
        //
    }

//    public function searchProduct(Request $request)
//    {
//        $result = Product::where('name', 'like', '%'.$request->get('searchRequest').'%')->get();
//
//        return json_encode($result);
//    }
//
//    public function searchOperation(Request $request)
//    {
//        $result = Operation::where('name', 'like', '%'.$request->get('searchRequest').'%')->get();
//
//        return json_encode($result);
//    }

    public function getSelectedProductOperations(Request $request)
    {
        $selected_product_id = $request->product_id;
        $product_operations_ids = ProductOperation::where('product_id', $selected_product_id)->pluck('operation_id');

        if($product_operations_ids->isNotEmpty()){
            foreach ($product_operations_ids as $key => $value){
                $product_operations[$key] = Operation::where('id', $value)->get();
            }
        } else {
            return false;
        }

        return $product_operations;
    }
}
