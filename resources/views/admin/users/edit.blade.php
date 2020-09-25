@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edycja pracownika {{ $user->name . ' ' . $user->surname }}</div>

                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Imię</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autofocus>

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
                                <input id="surname" type="text" class="form-control @error('name') is-invalid @enderror" name="surname" value="{{ $user->surname }}" required autofocus>

                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="login" class="col-md-4 col-form-label text-md-right">login</label>

                            <div class="col-md-6">
                                <input id="login" type="number" class="form-control @error('email') is-invalid @enderror" name="login" value="{{ $user->login }}" required autofocus>

                                @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label text-md-right">Rola</label>

                            <div class="col-md-6">
                                @foreach($roles as $role)
                                    <div class="form-check">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" @if($user->roles->pluck('id')->contains($role->id)) checked @endif>
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
                                    <input type="checkbox" name="departments[]" value="{{ $department->id }}" @if($user->departments->pluck('id')->contains($department->id)) checked @endif>
                                    <label>{{ $department->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}

                        <button type="submit" class="btn btn-primary">Zapisz</button>
                        <a class="btn btn-warning mr-3" href="{{ route('admin.users.index') }}">Anuluj</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
