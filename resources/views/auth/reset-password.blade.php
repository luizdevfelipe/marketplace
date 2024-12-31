@extends('layout/auth-layout')

@section('title', 'Redefinir Senha')

@section('body')

@section('legend', 'Nova Senha')

<form action="/reset-password" method="post" autocomplete="on" id="form">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <label for="iemail" class="mt-1 lead">Insira seu Email:</label><br>
    <input type="email" class="p-1" name="email" id="iemail" autocomplete="email" minlength="4" required maxlength="60"><br>

    <label for="ipassword" class="mt-1 lead">Insira sua nova senha:</label><br>
    <input type="password" class="p-1" name="password" id="ipassword" minlength="8" required maxlength="60"><br>

    <label for="ipassword_confirmation" class="mt-1 lead">Repita sua nova senha:</label><br>
    <input type="password" class="p-1" name="password_confirmation" id="ipassword_confirmation" minlength="8" required maxlength="60"><br>


    <input class="btn btn-success mt-1" type="submit" value="Confirmar">
</form>

@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

@endsection