@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pracownicy</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Imię</th>
                            <th scope="col">Nazwisko</th>
                            <th scope="col">Login</th>
                            <th scope="col">Rola</th>
                            <th scope="col">Wydział</th>
                            @can('manage-user')<th scope="col">Akcje</th>@endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->login }}</td>
                                <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                                <td>{{ implode(', ', $user->departments()->get()->pluck('name')->toArray()) }}</td>
                                @can('manage-user')
                                    <td class="d-flex">
                                        <a class="btn btn-primary mr-3" href="{{ route('admin.users.edit', $user->id) }}">Edytuj</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" class="btn btn-danger">Usuń</button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
