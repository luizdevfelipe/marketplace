@extends('layout/layout')

@section('title', "Olá, Bem Vindo")

@section('body')
<main>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12 col-md-4 text-center text-md-start" id="foto">
                @if (isset($user[0]['user_picture']))
                <img src="<?= asset('storage/' . $user[0]['user_picture']) ?>" alt="" class="align-center" style="width: 200px; height:200px">
                @else
                <img src="resources/user/profile/perfil.jpeg" alt="" class="align-center" style="width: 200px; height:200px">
                @endif
            </div>
            <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id="infouser">
                <?php if (isset($user[0]['lastname'])) : ?>
                    Bem vindo <?= $user[0]['name'] . ' ' . $user[0]['lastname'] ?>, você mora em <?= $user[0]['city'] . ' ' . $user[0]['state'] ?>
                    <br>

                    <form action="/perfil" enctype="multipart/form-data" method="post">@csrf<label for="ifoto" class="border border-dark rounded p-1 mt-1 text-center" style="width: 200px; cursor:pointer;">Clique e envie a Imagem</label><input type="file" name="foto" id="ifoto" style="display: none;"> <br> <input type="submit" class="border border-dark rounded p-1 my-1 text-center" value="Salvar Imagem"></form>

                    <a href="perfil/two-factor-manage" class="border border-dark rounded text-dark text-end fs-5 p-1">Gerenciar autenticação em dois fatores (2FA)</a>

                    <br>

                    <form action="<?= htmlspecialchars('/sair') ?>" method="post">
                        @csrf
                        <input type="submit" class="p-1 mt-2" value="Sair" name="sair">
                    </form>

                <?php else : ?>
                    <form action="<?= htmlspecialchars('/sair') ?>" method="post">
                        @csrf
                        <input type="submit" class="p-1 mt-2" value="Sair" name="sair">
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-12 col-md-4">
            </div>
            <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id='produtos'>
                Seus Produtos:<br>
                @if (!empty($products))

                @foreach ($products as $row)
                <a style='font-size:20px;' href='/produto/<?= $row["id"] ?>' class='text-dark'> <?= $row["name"] ?> </a> . <br>
                @endforeach

                @else
                Você não tem produtos à venda <br>
                @endif
                Seus Produtos: <br>
                <div class="rounded text-center border border-dark m-auto" style="max-width: 350px;">
                    <legend>Adicionar Produto</legend>
                    <form action="/produto/new" method="post" enctype="multipart/form-data">@csrf<label for="nproduto">Nome do produto:*</label><input type="text" title="Somente primeira letra maiúscula mínimo de 3 caracteres" name="nproduto" id="nproduto" minlength="4" maxlength="30" required class="m-1"><br><label for="descricao">Descrição do produto:*</label><br><textarea name="descricao" id="descricao" minlength="10" maxlength="200" cols="30" rows="5" required class="m-1" style="resize: none;"></textarea><br><label for="preco">Preço do produto:*</label><input type="number" name="preco" id="preco" step="0.01" required class="m-1"><br><label for="estoque">Quantidade de produtos:*</label><input type="number" name="estoque" id="estoque" min="1" required class="m-1"><br><label for="pfoto" class="p-1 border border-dark mb-1">Foto do Produto*</label><input type="file" name="pfoto" id="pfoto" style="display:none;" required><br>
                        <br><input type="submit" value="Publicar Produto" class="my-1 p-1">
                    </form>

                    <div id="diverro" class="erro bg-white text-danger rounded m-2 fs-5">
                        <?= $error ?? '' ?>
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="container mt-2">
        <div class="row">
            <div class="col-12 col-md-4">
            </div>
            <div class="col-12 col-md-8 text-center text-md-start pt-3 mt-3 mt-md-0 border border-dark rounded" id='produtos'>
                Compras Feitas:<br>
                <?php if (!empty($purchases)) : ?>
                    <?php foreach ($purchases as $row) : ?>
                        <a style='font-size:20px;' href="/produto/<?= $row['product_id'] ?>" class='text-dark'> <?= $row['name'] ?></a> <br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@endsection