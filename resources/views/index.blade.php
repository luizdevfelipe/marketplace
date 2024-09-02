@extends('layout/layout')

@section('title', 'MarketPlace')

@section('body')
<main>
  <div id="principal">
    <section id="texto"><strong>
        <mark>Tudo pra você</mark> <br><mark> de P a Q
      </strong></mark></section>
  </div>

  <div class="container-fluid bg-secondary" style="width: 100%; height: 70px;">

  </div>

  <div class="container">
    <div class="d-flex justify-content-evenly flex-wrap">

      <?php foreach ($rows as $row) : ?>
        <div class='card mt-3 p-2' style='width: 18rem; height:450px'>
          <img src='<?= asset('storage/' . $row['product_picture']); ?>' class='card-img-top rounded' style='height: 220px' alt='...'>
          <div class='card-body'>
            <h5 class='card-title'> <?= $row['name'] ?> </h5>
            <p class='card-text'><?= $row['description'] ?></p>
            <p class='card-text'>R$ <?= $row['price'] ?></p>
            <a href='/produto?id=<?= $row['id'] ?>' class='btn btn-primary'>Ver Produto</a>
          </div>
        </div>

      <?php endforeach; ?>
    </div>
  </div>

</main>

<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@endsection