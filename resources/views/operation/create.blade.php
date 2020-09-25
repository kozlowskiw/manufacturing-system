@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Utwórz nową operację</div>

                    <div class="card-body">
                        <form action="{{ route('operation.store') }}" method="POST">
                            @method('POST')
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Kod</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="code" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nazwa</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Utwórz</button>
                            <a href="{{ route('operation.index') }}"><button type="button" class="btn btn-primary">Anuluj</button></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
