@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Wszystkie powiązane operacje</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Produkt</th>
                            <th scope="col">Operacja</th>
                            <th scope="col">Czas wykonania operacji</th>
                            <th scope="col">Wspk</th>
                            <th scope="col">Czy poprawnie zmierzono</th>
                            <th scope="col">Akcja</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products_operations as $products_operation)
                            <tr>
                                <td>{{ $products_operation->p_name }}</td>
                                <td>{{ $products_operation->o_name }}</td>
                                <td>{{ $products_operation->expected_execution_time }}</td>
                                <td>{{ $products_operation->wspk }}</td>
                                <td>{{ $products_operation->measured_correctly }}</td>
                                <td class="d-flex">
                                    <a class="btn btn-primary mr-3" href="{{ route('product-operations.edit', $products_operation) }}">Edytuj</a>
                                    <form action="{{ route('product-operations.destroy', $products_operation) }}" method="POST">
                                        @method('DELETE')
                                        @csrf

                                        <button type="submit" class="btn btn-danger">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_blade_js')
    <script type="text/javascript" src="{{ URL::to('js/script.js') }}" defer></script>
@endsection
