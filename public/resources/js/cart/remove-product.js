window.addEventListener('DOMContentLoaded', function () {
    var count = 0;
    document.querySelectorAll('button.removeProduct').forEach(function (button) {
        count++;
        button.addEventListener('click', function (event) {
            let product_id = event.currentTarget.getAttribute('data-id')

            fetch(`/carrinho/${product_id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    _method: 'DELETE',
                })
            }).then(response => {
                if(response.ok) {
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
})