@extends('layout/layout')

@section('title', 'Nosso Produtos')

@section('body')
<main>
    <div class="container p-2">
        <div class="row row-cols-md-3 row-cols-lg-4">
            @if (!empty($results) && $results !== '')
                @foreach ($results as $row)
                    <div class='card p-2' style='height:450px'><img src="{{ asset('storage/' . $row['product_picture']) }}" class='card-img-top rounded' style='height: 220px' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'>{{ $row['name'] }}</h5>
                            <p class='card-text'>{{ $row['description'] }}</p>
                            <p class='card-text'>R${{ $row['price'] }}</p><a href="/produto/{{ $row['id'] }}" class='btn btn-primary'>Ver Produto</a>
                        </div>
                    </div>
                @endforeach

                {{ $results->links() }}
            @else
                <div class="container border border-dark rounded mt-5 d-block m-auto">
                    <h1 class="text-center p-5"> Produto não encontrado &#x1F641;<br>Tente utilizar palavras mais curtas como: pipoca, prato ou panela.</h1>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection