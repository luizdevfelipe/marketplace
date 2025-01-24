@extends('layout/layout')

@section('title', 'Carrinho')

@section('head')
<script src="resources/js/cart/remove-product.js"></script>
<script src="resources/js/cart/quantitySetter.js"></script>
@endsection

@section('body')
<main>
    <div class="container p-2 mt-2 rounded border border-dark">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="product{{ $product['id'] }}">
                    <div class='card col-3 mt-3 p-2 d-block m-auto' style='min-width: 250px; min-height:450px'>
                        <img src='<?= asset('storage/' . $product['product_picture']); ?>' class='card-img-top rounded d-block m-auto' style='max-height: 220px; max-width: 280px;' alt='...'>
                        <div class='card-body'>
                            <input type="checkbox" name="produto[]" id="iselectProduct{{ $product['id'] }}" class="selectedProduct" value="{{ $product['id'] }}">
                            <label for="iselectProduct{{ $product['id'] }}" class="fw-bold">Selecionar</label>
                            <h5 class='card-title'><?= $product['name'] ?></h5>
                            <p class='card-text'><?= $product['description'] ?></p>
                            <p class='card-text'>R$<?= $product['price'] ?></p>
                            <div class="text-center" style="font-size: 1.2em;user-select: none;">
                                <i class="bi bi-plus-circle quantitySetter"></i> 
                                <span class="quantity">1</span> 
                                <i class="bi bi-dash-circle quantitySetter"></i>
                            </div>
                            <button data-id="{{ $product['id'] }}" class='btn btn-primary removeProduct d-block m-auto'>Remover Produto</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <input type='submit' class='p-1 my-3' value='Finalizar Compra' name='comprou'>
        <?php else : ?>
            <p>Nenhum produto encontrado</p>
        <?php endif; ?>
    </div>
</main>
@endsection