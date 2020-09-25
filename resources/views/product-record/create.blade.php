@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ewidencja wykonywanych elementów</div>
                <div class="card-body">
                    <form action="{{ route('ewidencja.elementy.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input class="btn btn-secondary" type="submit" value="Zapisz">
                        <table id="products_table" data-url="{{ asset("storage/products.json") }}" data-height="344" data-id-field="id" data-select-item-name="product" data-search="true" data-single-select="true" data-click-to-select="true" data-search-align="left">
                            <thead class="thead-dark">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id" scope="col">Id</th>
                                <th data-field="code" scope="col">Kod</th>
                                <th data-field="name" scope="col">Nazwa</th>
                            </tr>
                            </thead>
                        </table>

                        <table id="operations_table" data-height="344" data-id-field="id" data-select-item-name="operation" data-search="true" data-single-select="true" data-click-to-select="true" data-search-align="left" >
                            <thead class="thead-dark">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id" scope="col">Id</th>
                                <th data-field="code" scope="col">Kod</th>
                                <th data-field="name" scope="col">Nazwa</th>
                            </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_blade_js')
    {{--    <script type="text/javascript" src="{{ URL::to('js/script.js') }}" defer></script>--}}
    <script type="text/javascript" src="{{ URL::to('js/product_operation_ajax.js') }}" defer></script>
@endsection
