@extends('layout/layout')

@section('title', 'Nosso Produtos')

@section('body')
<main>
    <div class="container text-center">
        <?php if (!empty($results) && $results !== '') : ?>
            <?php foreach ($results as $row) : ?>

                <div class='card d-block m-auto mt-3 p-2' style='width: 18rem; height:450px'><img src='<?= asset('storage/' . $row['product_picture']); ?>' class='card-img-top rounded' style='height: 220px' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'><?= $row['name'] ?></h5>
                        <p class='card-text'><?= $row['description'] ?></p>
                        <p class='card-text'>R$<?= $row['price'] ?></p><a href="/produto?id=<?= $row['id'] ?>" class='btn btn-primary'>Ver Produto</a>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else : ?>
            <div class="container border border-dark rounded mt-5 d-block m-auto">
                <h1 class="text-center p-5"> Produto não encontrado &#x1F641;<br>Tente utilizar palavras mais curtas como: pipoca, prato ou panela.</h1>
            </div>

        <?php endif; ?>
    </div>
</main>
@endsection