@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edycja rekordu</div>
                <div class="card-body">
                    <form action="{{ route('product-operations.update', $product_operation) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="product_name" class="col-md-4 col-form-label text-md-right">Produkt</label>

                            <div class="col-md-6">
                                <input id="product_name" type="text" class="form-control" name="product_name" value="{{ $product->name }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="operation_name" class="col-md-4 col-form-label text-md-right">Operacja</label>

                            <div class="col-md-6">
                                <input id="operation_name" type="text" class="form-control" name="operation_name" value="{{ $operation->name }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="operation_time" class="col-md-4 col-form-label text-md-right">Czas wykonania operacji</label>

                            <div class="col-md-6">
                                <input id="operation_time" min="0" type="number" class="form-control" name="operation_time" value="{{ $product_operation->expected_execution_time }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="wspk" class="col-md-4 col-form-label text-md-right">Wspk</label>

                            <div class="col-md-6">
                                <input id="wspk" min="0" step=".01" type="number" class="form-control" name="wspk" value="{{ $product_operation->wspk }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="measured_correctly" class="col-md-4 col-form-label text-md-right">Czy poprawnie zmierzono</label>

                            <div class="col-md-6">
                                <input type="checkbox" id="measured_correctly" name="measured_correctly" {{ ($product_operation->measured_correctly == 1 ? ' checked' : '') }} value="1">
                            </div>
                        </div>

                        <div class="form-buttons col-12 mt-5 text-right">
                            <button type="submit" class="btn btn-primary">Zapisz</button>
                            <a class="btn btn-warning ml-3" href="{{ route('product-operations.index') }}">Anuluj</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
