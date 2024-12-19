window.addEventListener('DOMContentLoaded', function () {
    document.querySelector('button#getCodes').addEventListener('click', function (event) {
        fetch('/user/two-factor-recovery-codes', {
            method: 'GET'
        }).then(response => {
            const contentType = response.headers.get("content-type");
        
            if (response.redirected) {
                window.location.href = response.url;
            } else if (response.ok && contentType && contentType.includes("application/json")) {
                return response.json();
            }
        })
        .then(function (data) {
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