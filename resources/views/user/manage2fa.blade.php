@extends('layout/layout')

@section('title', "Gerenciar 2FA")

@section('head')
<script src="/resources/js/two-factor/two-factor-code.js"></script>
@endsection

@section('body')

<div class="container mt-2">
    <div class="text-center text-md-start p-2 mt-3 border border-dark rounded">
        @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-4 font-medium text-sm">
            <div>
                <p>
                    Para continuar a ativação da autenticação em duas etapas<br>
                    escaneie este código QR com seu aplicativo de autenticação:
                </p>
                {!! Auth::user()->twoFactorQrCodeSvg() !!}
            </div>

            <p>Envie o código gerado pelo aplicativo para confirmarmos o processo</p>

            <form action="/user/confirmed-two-factor-authentication" method="post">
                @csrf
                <input type="text" name="code" id="" autocomplete="off" autofocus>
                <input type="submit" value="Enviar Código" class="btn btn-success">
            </form>
        </div>
        @elseif (session('status') == 'two-factor-authentication-confirmed')
        <div class="mb-4 font-medium text-sm">
            A autenticação de dois fatores foi confirmada e ativada!
        </div>
        @elseif (Auth::user()->two_factor_confirmed_at)
        <form action="/user/two-factor-authentication" method="post">
            @method('DELETE')
            @csrf
            <input type="submit" value="Remover 2FA" class="btn btn-danger">
        </form>

        <ul class="list-group m-2" style="width: 350px;" id='codes'></ul>

        <button id="getCodes" class="btn btn-primary">Visualizar códigos de recuperação</button>

        @else
        <form action="/perfil/enable-2fa" method="post">
            @csrf
            <input type="submit" value="Ativar 2FA" class="btn btn-success">
        </form>
        @endif

        <div id="diverro" class="erro bg-white text-danger rounded m-2 fs-5">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            {{ $error }} <br>
            @endforeach
            @endif
        </div>
    </div>
</div>

@endsection