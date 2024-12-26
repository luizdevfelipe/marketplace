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

                @if ($produto[0]['stock'] > 0)
                <form action='/produto/<?= $id ?>/buy' method='post'>
                    @csrf
                    <input type='submit' class='btn btn-success' value='Adicionar ao carrinho' name='comprar'>
                </form>
                @else
                <div class='btn btn-danger'>Produto Indisponível</div>
                @endif

            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
@endsection