@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('ewidencja.elementy.create') }}" type="button" class="btn btn-primary mb-3">Rozpocznij pracę na elemencie</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ewidencja wykonanych elementów</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Element</th>
                            <th scope="col">Operacja</th>
                            <th scope="col">Data rozpoczęcia</th>
                            <th scope="col">Data zakończenia</th>
                            <th scope="col">Ilość wykonanych elementów</th>
                            <th scope="col">Czas pracy</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data_rows as $data_row)
                            <tr>
                                <td>{{ $data_row['p_name'] }}</td>
                                <td>{{ $data_row['o_name'] }}</td>
                                <td>{{ $data_row['start_time'] }}</td>
                                <td>{{ $data_row['end_time'] }}</td>
                                <td>{{ $data_row['quantity'] }}</td>
                                <td>{{ $data_row['actual_working_time'] }}</td>
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
    {{--    <script type="text/javascript" src="{{ URL::to('js/script.js') }}" defer></script>--}}
    <script type="text/javascript" src="{{ URL::to('js/product_operation_ajax.js') }}" defer></script>
@endsection
