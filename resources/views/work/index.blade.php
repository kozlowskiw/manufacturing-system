@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Zanim przejdziesz dalej rozpocznij pracę</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Data</th>
                                <th scope="col">Czas</th>
                                <th scope="col">Zadeklaruj czas pracy w minutach</th>
                                <th scope="col">Zakończ pracę</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo date('Y-m-d') ?></td>
                                <td><?php echo date('H:i:s') ?></td>
                                {{--                                <td>{{ $user->login }}</td>--}}
                                {{--                                <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>--}}
                                <td>
                                    <form action="{{ route('ewidencja.praca.start') }}" method="POST">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <input type="number" name="declared_working_time" min="60" max="720" value="480">
                                        <button type="submit" class="btn btn-primary">Rozpocznij pracę</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('ewidencja.praca.end') }}" method="POST">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <button type="submit" class="btn btn-warning">Zakończ pracę</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ewidencja pracy</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Data rozpoczęcia</th>
                            <th scope="col">Data zakończenia</th>
                            <th scope="col">Zmiana</th>
                            <th scope="col">Zadeklarowany czas pracy</th>
                            <th scope="col">Rzeczywisty czas pracy</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user_work_records as $user_work_record)
                            <tr>
                                <td>{{ $user_work_record->start_time }}</td>
                                <td>{{ $user_work_record->end_time }}</td>
                                <td>{{ $user_work_record->shift }}</td>
                                <td>{{ $user_work_record->declared_working_time }}</td>
                                <td>{{ $user_work_record->actual_working_time }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

