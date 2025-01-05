@extends('layout/layout')

@section('title', 'Nosso Produtos')

@section('body')
<main>
    <div class="container py-2">
        <div class="row">
            <div class="col-12 col-md-7 text-center ">
                <img src="<?= asset('storage/' . $produto[0]['product_picture']); ?>" alt="produto" class="rounded" width="90%" height="400px">
            </div>
            <div class="col-12 col-md-5 border border-dark rounded" id="edita">
                <h1 class="text-center text-break"><?= $produto[0]['name'] ?></h1>
                <p class="mt-5 fs-5"><?= $produto[0]['description'] ?></p>
                <p class="mb-0">Produtos Disponíveis: <?= $produto[0]['stock'] ?></p>
                <p class="text-success fs-5">R$<?= $produto[0]['price'] ?></p>

                <button class='btn btn-primary' onclick="edita_produto()">Editar dados do Produto</button>
            </div>
        </div>
    </div>
</main>

<script>
    function edita_produto() {
        div = document.getElementById('edita')
        form = `
            <br>
            <form class="border border-success mb-3 m-1 p-2 rounded" action="/produto/{{ $produto[0]['id'] }}/modify" method="post">
            @csrf
            <div class="mb-3">
            <label for="nproduto" class="form-label">Nome do produto:*</label>
            <input type="text" name="nproduto" id="nproduto" minlength="4" maxlength="30" required class="form-control">
            </div>
            <div class="mb-3">
            <label for="descricao" class="form-label">Descrição do produto:*</label>
            <textarea name="descricao" id="descricao" minlength="10" maxlength="200" cols="28" rows="5" required class="form-control" style="resize: none;"></textarea>
            </div>
            <div class="mb-3">
            <label for="preco" class="form-label">Preço do produto:*</label>
            <input type="number" name="preco" id="preco" step="0.01" required class="form-control">
            </div>
            <div class="mb-3">
            <label for="estoque" class="form-label">Quantidade de produtos:*</label>
            <input type="number" name="estoque" id="estoque" min="1" required class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Alterar Produto</button>
            </form>
        `;
        
        div.innerHTML = form;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@endsection