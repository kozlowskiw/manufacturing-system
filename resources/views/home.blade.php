@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(auth()->user()->hasRole('admin'))
                    <div class="card-header"><h1 class="text-center">Witaj w panelu administratora!</h1></div>
                @elseif(auth()->user()->hasRole('technolog'))
                    <div class="card-header"><h1 class="text-center">Witaj w panelu technologa!</h1></div>
                @elseif(auth()->user()->hasRole('pracownik'))
                    <div class="card-header"><h1 class="text-center">Witaj w pracy!</h1></div>
                @else
                    <div class="card-header"><h1 class="text-center">Witaj!</h1></div>
                @endif

                <div class="card-body">
                    <h4 class="card-title text-center my-4">PRZEJDŹ DO</h4>

                    <div class="goto-links">
                        <a class="card-panel" href="{{ route('users.show', auth()->user()) }}">
                            Twoje dane
                        </a>

                        <a class="card-panel" href="{{ route('ewidencja.praca.create') }}">
                            Ewidencja pracy
                        </a>

                        @if(auth()->user()->hasAnyRoles(['pracownik produkcji', 'admin']))

                            <a class="card-panel" href="{{ route('ewidencja.elementy.index') }}">
                                Ewidencja elementów
                            </a>

                        @endif

                        @if(auth()->user()->hasRole('admin'))

                            <a class="card-panel" href="{{ route('admin.users.index') }}">
                                Zarządzanie pracownikami
                            </a>
                            <a class="card-panel" href="{{ route('admin.users.create') }}">
                                Utwórz konto pracownika
                            </a>

                        @endif

                        @if(auth()->user()->hasAnyRoles(['technolog', 'admin']))

                            <a class="card-panel" href="{{ route('product.index') }}">
                                Elementy
                            </a>
                            <a class="card-panel" href="{{ route('operation.index') }}">
                                Operacje
                            </a>
                            <a class="card-panel" href="{{ route('product-operations.create') }}">
                                Powiąż operacje z elementami
                            </a>
                            <a class="card-panel" href="{{ route('product-operations.index') }}">
                                Zarządzaj powiązanymi operacjami
                            </a>

                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
