import { removeProductDiv } from '@/js/cart/remove-product.js';

window.addEventListener('DOMContentLoaded', function () {
    var X_CSRF_TOKEN = this.document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

    let finishButton = document.querySelector('input[name="comprou"]');
    if (finishButton) {
        finishButton.addEventListener('click', function () {
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
                        removeProductDiv(selectedProductsCartIds)
                        window.location.href = data.mercado_pago_url;
                    }
                });
            }
        })
    }
});
