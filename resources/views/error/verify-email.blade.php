@extends('layout/layout')

@section('title', 'MarketPlace')

@section('body')
<main class="container border border-dark rounded mt-5 d-block m-auto">
  <h1 class="text-center display-2 p-5">Para acessar o site, verifique seu email</h1>
  <form action="/email/verification-resent" method="post">
    @csrf    
    <input class="btn btn-success mt-1" type="submit" value="Reenviar o email de verificação">
  </form>
  <div id="diverro" class="erro bg-white text-danger rounded m-2 fs-5">
    <?= $error ?? '' ?>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    {{ $error }} <br>
    @endforeach
    @endif
  </div>
</main>
@endsection