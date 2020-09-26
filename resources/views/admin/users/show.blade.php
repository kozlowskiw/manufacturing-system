@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Twoje dane</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Imię</th>
                            <th scope="col">Nazwisko</th>
                            <th scope="col">Rola</th>
                            <th scope="col">Wydział</th>
                            <th scope="col">Czas przepracowany w ciągu ostatniego miesiąca</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                            <td>{{ implode(', ', $user->departments()->get()->pluck('name')->toArray()) }}</td>
                            <td>{{ $last_month_working_time }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
