window.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.quantitySetter').forEach(function (quantityButton) {
        quantityButton.addEventListener('click', function () {
            quantitySpan = document.querySelector('span.quantity');

            let quantity = parseInt(quantitySpan.innerHTML, 10);

            if (quantityButton.classList.contains('bi-dash-circle') && quantity > 1) {
                quantitySpan.innerHTML = quantity - 1;

            } else if (quantityButton.classList.contains('bi-plus-circle') && quantity < 10) {
                quantitySpan.innerHTML = quantity + 1;
            }
        })
    })
})