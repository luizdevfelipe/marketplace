@extends('layout/layout')

@section('title', 'Carrinho')

<?php
if (empty($idproduto)) {
    $idproduto = [];
}
if (empty($idcarrinho)) {
    $idcarrinho = [];
}
if (empty($estoque)) {
    $estoque = [];
}
?>

@section('body')
<main>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md border p-1 text-center ">
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $product) : ?>
                        <?php
                        array_push($idproduto, $product['product_id']);
                        array_push($idcarrinho, $product['id']);
                        array_push($estoque, $product['stock']);
                        ?>
                        <div class='card col-3 mt-3 p-2 d-block m-auto' style='min-width: 250px; min-height:450px'>
                            <img src='<?= asset('storage/' . $product['product_picture']); ?>' class='card-img-top rounded' style='max-height: 220px; max-width: 280px;' alt='...'>
                            <div class='card-body'>
                                <h5 class='card-title'><?= $product['name'] ?></h5>
                                <p class='card-text'><?= $product['description'] ?></p>
                                <p class='card-text'>R$<?= $product['price'] ?></p>
                                <form action="/carrinho/<?= $product['id'] ?>" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class='btn btn-primary' value="Remover Produto">
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Nenhum produto encontrado</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <?php if (!empty($products)) : ?>
            <form action='/carrinho' method='post'>@csrf<input type='submit' class='p-1 my-3' value='Finalizar Compra' name='comprou'></form>
        <?php endif; ?>
    </div>

</main>
@endsection