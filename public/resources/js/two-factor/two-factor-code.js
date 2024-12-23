window.addEventListener('DOMContentLoaded', function () {
    document.querySelector('button#getCodes').addEventListener('click', function (event) {
        show2FACodes()
    })

    document.querySelector('button#newCodes').addEventListener('click', function (event) {
        fetch('/user/two-factor-recovery-codes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        event.target.remove()
        show2FACodes()
    });
})

function show2FACodes() {
    fetch('/user/two-factor-recovery-codes', {
        method: 'GET'
    }).then(response => {
        const contentType = response.headers.get("content-type");

        if (response.redirected) {
            window.location.href = response.url;
        } else if (response.ok && contentType && contentType.includes("application/json")) {
            return response.json();
        }
    }).then(function (data) {
        list = document.querySelector('ul#codes')
        list.innerHTML = ''
        data.forEach(code => {
            var li = document.createElement('li')
            li.classList.add('list-group-item')
            li.innerHTML = code
            list.appendChild(li)
        });
        document.querySelector('button#getCodes').remove()
    })
}