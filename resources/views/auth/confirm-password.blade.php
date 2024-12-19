@extends('layout/auth-layout')

@section('title', 'Confirmar Senha')

@section('body')

@section('legend', 'Confirmar Senha')
<form action="/confirm-password" method="post" autocomplete="on" id="form">
    @csrf
    <label for="ipassword" class="mt-1 lead">Insira sua Senha:</label><br>
    <input type="password" class="p-1" name="password" id="ipassword" autocomplete="current-password" minlength="8" required maxlength="60"><br>

    <input class="btn btn-success mt-1" type="submit" value="Confirmar Senha">
</form>
@endsection