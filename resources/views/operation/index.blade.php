@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a class="btn btn-primary mb-3" href="{{route('operation.create')}}">Dodaj nową operację</a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista wszystkich operacji</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Kod</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($operations as $operation)
                                <tr>
                                    <td>{{ $operation->code }}</td>
                                    <td>{{ $operation->name }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('operation.edit', $operation->id) }}"><button type="button" class="btn btn-primary mr-3">Edytuj</button></a>
                                        <form action="{{ route('operation.destroy', $operation) }}" method="POST">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit" onclick="return confirm('Potwierdź usunięcie operacji')" class="btn btn-danger">Usuń</button>
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
