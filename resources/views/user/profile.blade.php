@extends('layout/layout')

@section('title', "Olá, Bem Vindo")

@section('head')
<script src="{{ Vite::asset('resources/js/profile/load-paginate.js') }}"></script>
@endsection

@section('body')
<main>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12 col-md-4 text-center text-md-start" id="foto">
                @if (isset($user[0]['user_picture']))
                <img src="<?= asset('storage/' . $user[0]['user_picture']) ?>" alt="" class="align-center" style="width: 200px; height:200px">
                @else
                <img src="{{ Vite::asset('resources/images/user/profile/perfil.jpeg') }}" alt="Imagem de perfil" class="align-center" style="width: 200px; height:200px">
                @endif
            </div>
            <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id="infouser">
                Bem vindo {{ $user[0]['name'] . ' ' . $user[0]['lastname'] }}, você mora em {{ $user[0]['city'] . ' ' . $user[0]['state'] }}
                <br>

                <form action="/perfil" enctype="multipart/form-data" method="post">@csrf<label for="ifoto" class="border border-dark rounded p-1 mt-1 text-center" style="width: 200px; cursor:pointer;">Clique e envie a Imagem</label><input type="file" name="foto" id="ifoto" style="display: none;"> <br> <input type="submit" class="border border-dark rounded p-1 my-1 text-center" value="Salvar Imagem"></form>

                <a href="perfil/two-factor-manage" class="border border-dark rounded text-dark text-end fs-5 p-1">Gerenciar autenticação em dois fatores (2FA)</a>
                <br>

                <form action="/sair" method="post">
                    @csrf
                    <input type="submit" class="p-1 rounded mt-2 btn-logout" value="Sair" name="sair">
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-12 col-md-4">
            </div>
            <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded">
                Seus Produtos:<br>
                <section id="products">
                </section>

                <x-profile.pendent-products :pendentPurchases="$pendentPurchases" :link="$link" />

                <div class="rounded text-center border border-dark m-auto" style="max-width: 350px;">
                    <legend class="text-center mb-3">Adicionar Produto</legend>

                    <div id="diverro" class="erro bg-white text-danger rounded m-2 fs-5">
                        {{ $error ?? '' }}
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                        @endforeach
                        @endif
                    </div>

                    <form action="/produto/new" method="post" enctype="multipart/form-data" class="p-3">
                        @csrf
                        <div class="mb-3">
                            <label for="nproduto" class="form-label">Nome do produto:*</label>
                            <input type="text" title="Somente primeira letra maiúscula mínimo de 3 caracteres" name="nproduto" id="nproduto" minlength="4" maxlength="30" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição do produto:*</label>
                            <textarea name="descricao" id="descricao" minlength="10" maxlength="200" cols="30" rows="5" required class="form-control" style="resize: none;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço do produto:*</label>
                            <input type="number" name="preco" id="preco" step="0.01" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="estoque" class="form-label">Quantidade de produtos:*</label>
                            <input type="number" name="estoque" id="estoque" min="1" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="pfoto" class="form-label">Foto do Produto*</label>
                            <div class="rounded border border-dark p-2">
                                <p class="fs-6">Clique ou arraste uma imagem</p>
                                <input type="file" name="pfoto" id="pfoto" required class="form-control">
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" value="Publicar Produto" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-12 col-md-4">
            </div>
            <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" style="min-height: 216px;">
                Compras Feitas:<br>
                <section id="purchases">
                </section>
            </div>
        </div>
    </div>

</main>
@endsection