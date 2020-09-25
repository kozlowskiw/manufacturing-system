@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Powiąż operacje z elementami</div>
                <div class="card-body">
                    <form action="{{ route('product-operations.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input class="btn btn-secondary" type="submit" value="Zapisz">
                        <table id="products_table" data-toggle="table" data-height="340" data-id-field="product_id" data-select-item-name="product" data-search="true" data-single-select="true" data-click-to-select="true" data-search-align="left">
                            <thead class="thead-dark">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th scope="col" data-field="product_id">Id</th>
                                <th scope="col" data-field="code">Kod</th>
                                <th scope="col" data-field="name">Nazwa</th>
                            </tr>
                            </thead>
                            <tbody id="product_table_body">
                            @foreach($products as $product)
                                <tr>
                                    <td></td>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <table id="operations_table" data-toggle="table" data-height="340" data-id-field="operation_id" data-single-select="true" data-select-item-name="operation" data-search="true" data-click-to-select="true" data-search-align="left">
                            <thead class="thead-dark">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th scope="col" data-field="operation_id">Id</th>
                                <th scope="col" data-field="code">Kod</th>
                                <th scope="col" data-field="name">Nazwa</th>
                            </tr>
                            </thead>
                            <tbody id="product_table_body">
                            @foreach($operations as $operation)
                                <tr>
                                    <td></td>
                                    <td>{{ $operation->id }}</td>
                                    <td>{{ $operation->code }}</td>
                                    <td>{{ $operation->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                            <tr>
                                <td>
                                    <label for="operation_time">Czas wykonania operacji</label>
                                    <input type="text" min="0" class="form-control" name="operation_time" id="operation_time" required>
                                </td>
                                <td>
                                    <label for="coefficient">Wspk</label>
                                    <input type="number" class="form-control" name="coefficient" min="0" id="coefficient" step=".01" required>
                                </td>
                                <td>
                                    <label for="measured_correctly">Czy poprawnie zmierzono</label>
                                    <input type="checkbox" id="measured_correctly" name="measured_correctly" value="1" {{ old('measured_correctly') ? 'checked="checked"' : '' }}>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_blade_js')
    <script type="text/javascript" src="{{ URL::to('js/script.js') }}" defer></script>
@endsection
