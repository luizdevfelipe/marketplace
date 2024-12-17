@extends('layout/layout')

@section('title', "Gerenciar 2FA")

@section('body')

<div class="container mt-2">
    <div class="text-center text-md-start p-2 mt-3 border border-dark rounded" id='produtos'>

        <form action="/perfil/enable-2fa" method="post">
            @csrf
            <input type="submit" value="Ativar 2FA" class="btn btn-success">
        </form>

        @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-4 font-medium text-sm">
            <div>
                <p>Escaneie este código QR com seu aplicativo de autenticação:</p>
                {!! Auth::user()->twoFactorQrCodeSvg() !!}
            </div>

            <form action="/user/confirmed-two-factor-authentication" method="post">
                @csrf
                <input type="text" name="" id="">
                <input type="submit" value="Enviar Código" class="btn btn-success">
            </form>
        </div>
        @endif


        @if (session('status') == 'two-factor-authentication-confirmed')
        <div class="mb-4 font-medium text-sm">
            Two factor authentication confirmed and enabled successfully.
        </div>
        @endif

    </div>
</div>

@endsection