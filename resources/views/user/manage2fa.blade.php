@extends('layout/layout')

@section('title', "Gerenciar 2FA")

@section('body')

<div class="container mt-2">
    <div class="text-center text-md-start p-2 mt-3 border border-dark rounded" id='produtos'>

        <form action="/user/two-factor-authentication" method="post">
            @csrf
            <input type="submit" value="Ativar 2FA" class="btn btn-success">
        </form>

        @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-4 font-medium text-sm">
            Please finish configuring two factor authentication below.
        </div>
        @endif

    </div>
</div>

@endsection