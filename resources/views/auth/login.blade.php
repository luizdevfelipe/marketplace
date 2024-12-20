@extends('layout/auth-layout')

@section('title', 'LogIn')

@section('body')

<div class="lead text-center rounded p-1" id="registro" style="background-color: #ffffff9d; ">
    <p>Não tem cadastro? <br><a class="btn bg-success border border-dark p-1 text-white" href="/registro">Registre-se</a> agora</p>
</div>

@section('legend', 'Login')

<form action="/login" method="post" autocomplete="on" id="form">
    @csrf
    <label for="iemail" class="mt-1 lead">Email:</label><br>
    <input type="text" class="p-1" name="email" id="iemail" autocomplete="email" required minlength="4" maxlength="50"><br>
    <label for="ipassword" class="mt-1 lead">Insira sua Senha:</label><br>
    <input type="password" class="p-1" name="password" id="ipassword" autocomplete="current-password" minlength="8" required maxlength="60"><br>
    <div class="bg-white d-block mt-1 m-auto rounded" style="max-width: 140px; padding: 2px 1px;">
        <label for="iremember">Lembrar usuário</label>
        <input type="checkbox" name="remember" id="iremember">
    </div><br>
    <input class="btn btn-success mt-1" type="submit" value="Entrar">
</form>

@endsection