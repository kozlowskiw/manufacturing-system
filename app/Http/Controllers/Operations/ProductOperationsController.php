<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Operation;
use App\Product;
use App\ProductOperation;
use http\Env\Response;
use Illuminate\Http\Request;

class ProductOperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products_operations = ProductOperation::join('products as p', 'product_operations.product_id', '=', 'p.id' )
            ->join('operations as o', 'product_operations.operation_id', '=', 'o.id' )
            ->select('product_operations.*', 'p.name as p_name', 'o.name as o_name')
            ->orderBy('id', 'asc')
            ->get();

        return view('product-operation.index')->with([
            'products_operations'=>$products_operations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $products = Product::all();
        $operations = Operation::all();
        $products_operations = ProductOperation::all();

        return view('product-operation.create')->with([
            'products' => $products,
            'operations' => $operations,
            'products_operations'=>$products_operations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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
            $product_operation = new ProductOperation();

            $product_operation->product_id = $request->product;
            $product_operation->operation_id = $request->operation;
            $product_operation->expected_execution_time = $request->operation_time;
            $product_operation->wspk = $request->coefficient;

            if ($request->has('measured_correctly')) {
                $product_operation->measured_correctly = $request->measured_correctly;
            } else {
                $product_operation->measured_correctly = 0;
            }

            $product_operation->save();
            $request->session()->flash('success', 'Pomyślnie powiązano produkt z operacją!');
            return redirect()->route('product-operations.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductOperation  $productOperation
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOperation $productOperation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductOperation  $productOperation
     * @return \Illuminate\View\View
     */
    public function edit(ProductOperation $productOperation)
    {
        $product = Product::where('id', $productOperation->product_id)->first();
        $operation = Operation::where('id', $productOperation->operation_id)->first();

        return view('product-operation.edit')->with([
            'product_operation' => $productOperation,
            'product' => $product,
            'operation' => $operation
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductOperation  $productOperation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ProductOperation $productOperation)
    {
        $productOperation->expected_execution_time = $request->operation_time;
        $productOperation->wspk = $request->wspk;

        if ($request->has('measured_correctly')) {
            $productOperation->measured_correctly = $request->measured_correctly;
        } else {
            $productOperation->measured_correctly = 0;
        }

        if($productOperation->save()){
            $request->session()->flash('success', 'Rekord został zaktualizowany!');
        }else{
            $request->session()->flash('danger', 'Wystąpił błąd podczas aktualizaji danych.');
        }

        return redirect()->route('product-operations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductOperation  $productOperation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, ProductOperation $productOperation)
    {
        $productOperation->delete();

        $request->session()->flash('success', 'Rekord został usunięty');

        return redirect()->route('product-operations.index');
    }
}
