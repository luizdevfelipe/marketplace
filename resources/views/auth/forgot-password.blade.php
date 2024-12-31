@extends('layout/auth-layout')

@section('title', 'Redefinir Senha')

@section('body')

@section('legend', 'Informe seu email')
<div class="text-center rounded p-1" id="registro" style="background-color: #ffffff9d; ">
    <p>Um email será enviado para você com um link para redefinir a senha</p>
</div>


<form action="/forgot-password" method="post" autocomplete="on" id="form">
    @csrf
    <label for="iemail" class="mt-1 lead">Insira seu Email:</label><br>
    <input type="email" class="p-1" name="email" id="iemail" autocomplete="email" minlength="4" required maxlength="60"><br>

    <input class="btn btn-success mt-1" type="submit" value="Enviar email">
</form>

@endsection