@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Praca rozpoczęta!</div>
                <div class="card-body">
                    <form action="{{ route('ewidencja.elementy.update', $product_record->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Start pracy</th>
                                    <th scope="col">Aktualny czas</th>
                                    <th scope="col">Ile elementów wykonano</th>
                                    <th scope="col">Zakończ pracę</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$product_record->start_time}}</td>
                                    <td><?php echo date('H:i:s') ?></td>
                                    <td><input type="number" id="quantity" name="quantity" min="0" max="9999"></td>
                                    <td>
                                        <button type="submit" class="btn btn-warning">Zakończ pracę</button>
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
    {{--    <script type="text/javascript" src="{{ URL::to('js/script.js') }}" defer></script>--}}
    <script type="text/javascript" src="{{ URL::to('js/product_operation_ajax.js') }}" defer></script>
@endsection
