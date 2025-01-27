window.addEventListener('DOMContentLoaded', function () {
    var X_CSRF_TOKEN = this.document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('button.removeProduct').forEach(function (button) {
        button.addEventListener('click', function (event) {
            var product_id = event.currentTarget.getAttribute('data-id')

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
                    removeProductDiv(product_id)
                }
            })
        })
    })

});

function removeProductDiv(product_id) {
    let count = 0;
    document.querySelectorAll('button.removeProduct').forEach(function () {
        count++;
    });

    if (typeof product_id === "object") {
        product_id.forEach(id => {
            document.querySelector(`div.product${id}`).remove()
            count--;
        })
    } else {
        document.querySelector(`div.product${product_id}`).remove()
        count--;
    }
    if (count < 1) {
        document.querySelector("input[name='comprou']").remove()
        document.querySelector("div.container").innerHTML = "<p>Nenhum produto encontrado</p>"
    }
    return count;
}