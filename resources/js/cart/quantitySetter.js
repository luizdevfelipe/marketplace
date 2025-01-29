window.addEventListener('DOMContentLoaded', function () {
    var X_CSRF_TOKEN = this.document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    document.querySelectorAll('.quantitySetter').forEach(function (quantityButton) {
        quantityButton.addEventListener('click', function (event) {
            let quantitySpan = event.target.parentElement.querySelector('.quantity');

            let quantity = parseInt(quantitySpan.innerHTML, 10);

            if (quantityButton.classList.contains('bi-dash-circle') && quantity >= 1) {
                quantity--;
            } else if (quantityButton.classList.contains('bi-plus-circle') && quantity <= 10) {
                quantity++;
            }

            let cart_id = event.target.parentElement.parentElement.querySelector('.removeProduct').getAttribute('data-id');

            if (quantity > 0 && quantity <= 10) {
                fetch(`/carrinho/${cart_id}`,
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': X_CSRF_TOKEN,
                        },
                        body: JSON.stringify({
                            quantity: quantity,
                            _method: 'PUT',
                        })
                    }
                ).then(response => {
                    if (response.ok) {
                        quantitySpan.innerHTML = quantity;
                    } else {
                        alert('Erro ao atualizar a quantidade do produto');
                    }
                });
            }
        })
    })
})