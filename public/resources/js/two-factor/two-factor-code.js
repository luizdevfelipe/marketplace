window.addEventListener('DOMContentLoaded', function () {
    document.querySelector('button#getCodes').addEventListener('click', function (event) {
        fetch('/user/two-factor-recovery-codes', {
            'method': 'GET'
        }).then(function (response) {
            return response.json()
        }).then(function (data) {
            data.forEach(code => {
                var li = document.createElement('li')
                li.classList.add('list-group-item')
                li.innerHTML = code
                document.querySelector('ul#codes').appendChild(li)
            });
            event.target.remove()
        })
    })
})