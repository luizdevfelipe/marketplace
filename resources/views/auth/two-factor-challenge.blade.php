@extends('layout/auth-layout')

@section('title', 'Confirmar Senha')

@section('head')

@vite(['resources/js/two-factor/two-factor-challenge.js'])

@endsection

@section('body')

@section('legend', '2FA')


<form action="/two-factor-challenge" method="post" autocomplete="off" id="confirm2fa">
    @csrf
    <div id="codeLabel">
        <label for="icode" class="mt-1 lead">Código de autenticação em dois fatores:</label><br>
        <input type="text" autofocus class="p-1" name="code" id="icode" minlength="6" required maxlength="6"><br>
    </div>   

    <input class="btn btn-success mt-1" type="submit" value="Enviar código">
</form>

<div class="m-1">
    <button class="translucentButton" id="recovery">Usar código de recuperação</button>
</div>
@endsection