const code = '<label for="irecovery_code" class="mt-1 lead">Insira um código de recuperação válido:</label><br><input type="text" class="p-1" name="recovery_code" id="irecovery_code" required>'

window.addEventListener('DOMContentLoaded', function () {
    document.querySelector('button#recovery').addEventListener('click', function (event) {
        document.querySelector('div#codeLabel').innerHTML = code
        event.target.remove()
    })
})