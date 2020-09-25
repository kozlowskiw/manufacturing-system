@extends('layouts.app')

{{--plik tworzący stronę umożliwiającą dodawanie nowego konta pracownika--}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Utwórz konto pracownika</div>

                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @method('POST')
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Imię</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">Nazwisko</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" required autofocus>

                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="login" class="col-md-4 col-form-label text-md-right">Login</label>

                                <div class="col-md-6">
                                    <input id="login" type="number" min="0" class="form-control @error('login') is-invalid @enderror" name="login" required autofocus>

                                    @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="roles" class="col-md-4 col-form-label text-md-right">Role</label>

                                <div class="col-md-6">
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                                            <label>{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="departments" class="col-md-4 col-form-label text-md-right">Wydział</label>

                                <div class="col-md-6">
                                    @foreach($departments as $department)
                                        <div class="form-check">
                                            <input type="checkbox" name="departments[]" value="{{ $department->id }}">
                                            <label>{{ $department->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Utwórz</button>
                            <a href="{{ route('admin.users.index') }}"><button type="button" class="btn btn-primary">Anuluj</button></a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
