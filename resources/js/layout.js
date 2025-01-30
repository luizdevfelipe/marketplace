window.addEventListener('DOMContentLoaded', function () {
    document.querySelector('button#buscarProduto').addEventListener('click', function (event) {
        event.preventDefault();
        let produto = document.querySelector('input#ipesquisa').value;
        if (produto) {
            window.location.href = `/produto/search/${produto}`;
        }
    });
});