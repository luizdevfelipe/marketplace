@extends('layout/auth-layout')

@section('title', 'Confirmar Senha')

@section('body')
<main>
    <div class="container-fluid d-grid justify-content-center align-items-center " style="height: 100vh;">
        <fieldset class="border border-dark rounded text-center w350" style="height: 250px;">
            <legend class="mt-1 display-6" id="legenda">Confirmar Senha</legend>
            <form action="/user/confirm-password" method="post" autocomplete="on" id="form">
                @csrf
                <label for="ipassword" class="mt-1 lead">Insira sua Senha:</label><br>
                <input type="password" class="p-1" name="password" id="ipassword" autocomplete="current-password" minlength="8" required maxlength="60"><br>

                <input class="btn btn-success mt-1" type="submit" value="Confirmar Senha">
            </form>
            <div id="diverro" class="erro bg-white text-danger rounded m-2 fs-5">
                <?= $error ?? '' ?>
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                {{ $error }} <br>
                @endforeach
                @endif
            </div>
        </fieldset>
</main>
@endsection