@extends('layout/auth-layout')

@section('title', 'LogIn')

@section('body')
<main>
    <div class="container-fluid d-grid justify-content-center" style="height: 100vh;">
        <div class="lead text-center" id="registro">
            <p>Não tem cadastro? <br><a class="btn bg-success border border-dark p-1 text-white" href="/registro">Registre-se</a> agora</p>
        </div>
        <fieldset class="border border-dark rounded text-center w350" style="height: 310px;">
            <legend class="mt-1 display-6" id="legenda">Login</legend>
            <form action="<?= htmlspecialchars('/login') ?>" method="post" autocomplete="on" id="form">
                @csrf
                <label for="iemail" class="mt-1 lead">Email:</label><br>
                <input type="text" class="p-1" name="email" id="iemail" autocomplete="email" required minlength="4" maxlength="50"><br>
                <label for="ipassword" class="mt-1 lead">Insira sua Senha:</label><br>
                <input type="password" class="p-1" name="password" id="ipassword" autocomplete="current-password" minlength="8" required maxlength="60"><br>
                <input class="btn btn-success mt-3" type="submit" value="Entrar">
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