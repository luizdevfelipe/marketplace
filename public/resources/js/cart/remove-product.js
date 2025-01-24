window.addEventListener('DOMContentLoaded', function () {
    var count = 0;
    var X_CSRF_TOKEN = this.document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('button.removeProduct').forEach(function (button) {
        count++;
        button.addEventListener('click', function (event) {
            let product_id = event.currentTarget.getAttribute('data-id')

            fetch(`/carrinho/${product_id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': X_CSRF_TOKEN,
                },
                body: JSON.stringify({
                    _method: 'DELETE',
                })
            }).then(response => {
                if (response.ok) {
                    document.querySelector(`div.product${product_id}`).remove()
                    if (count == 1) {
                        document.querySelector("input[name='comprou']").remove()
                        document.querySelector("div.container").innerHTML = "<p>Nenhum produto encontrado</p>"
                    }
                    count--;
                }
            })
        })
    })

    var selectedProductsCartIds = [];
    document.querySelectorAll('input.selectedProduct').forEach(function (input) {
        input.addEventListener('change', function () {
            if (input.checked) {
                selectedProductsCartIds.push(parseInt(input.value, 10));
            } else {
                const index = selectedProductsCartIds.indexOf(input.value);
                if (index > -1) {
                    selectedProductsCartIds.splice(index, 1);
                }
            }
        });
    });

    document.querySelector('input[name="comprou"]').addEventListener('click', function () {
        if (selectedProductsCartIds.length > 0) {
            fetch('/carrinho', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': X_CSRF_TOKEN,
                },
                body: JSON.stringify({
                    selectedProductsCartIds: selectedProductsCartIds,
                })
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
            }).then(data => {
                if (data && data.mercado_pago_url) {
                    window.location.href = data.mercado_pago_url;
                }
            });
        }
    })
})