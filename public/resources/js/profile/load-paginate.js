document.addEventListener('DOMContentLoaded', async function (event) {
    await loadPaginate()

    document.addEventListener('click', function (event) {
        let href = event.target.getAttribute('href');
        let data_pag = event.target.getAttribute('data-pag');

        if (
            event.target && href && data_pag
            && (event.target.id === 'proximo' || event.target.id === 'anterior')
        ) {
            fetch(href, {
                method: 'GET',
            })
                .then(response => response.json())
                .then(function (data) {

                    let section = document.querySelector(`section#${data_pag}`);
                    section.innerHTML = '';

                    id = data_pag === 'products' ? 'id' : 'product_id';

                    data['data'].forEach(item => {
                        section.innerHTML += `<a style='font-size:20px;' href='/produto/${item[`${id}`]}' class='text-dark'>${item['name']}</a><br>`;
                    });

                    section.innerHTML += paginateButtons(data, data_pag);
                });
        }
    });
})

async function loadPaginate() {
    fetch('perfil/load', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(function (data) {
            text = '<p>Nenhum resultado encontrado</p>'
            let sectionProducts = document.querySelector('section#products');
            let sectionPurchases = document.querySelector('section#purchases');

            if (data['purchases'] !== null) {
                data['purchases']['data'].forEach(purchases => {
                    sectionPurchases.innerHTML += `<a style='font-size:20px;' href='/produto/${purchases['product_id']}' class='text-dark'>${purchases['name']}</a><br>`;
                })
                sectionPurchases.innerHTML += paginateButtons(data['purchases'], 'purchases');
            } else {
                sectionPurchases.innerHTML = text;
            }

            if (data['products'] !== null) {
                data['products']['data'].forEach(product => {
                    sectionProducts.innerHTML += `<a style='font-size:20px;' href='/produto/${product['id']}' class='text-dark'>${product['name']}</a><br>`;
                });
                sectionProducts.innerHTML += paginateButtons(data['products'], 'products');
            } else {
                sectionProducts.innerHTML = text;
            }
        })
}


function paginateButtons(data, paginateFor) {
    html = '';

    if (data['data'] !== null) {
        anteriorLabel = data['links'][0]['label'];
        proximoLabel = data['links'][data['links'].length - 1]['label'];

        proximoLink = data['next_page_url'];
        anteriorLink = data['prev_page_url'];

        html += '<nav class="d-flex justify-items-center justify-content-between"><div class="d-flex justify-content-between flex-fill"><ul class="pagination">';

        // Previous Page Link  
        if (data['current_page'] === 1) {
            html += `<li class="page-item disabled" aria-disabled="true"><span class="page-link">${anteriorLabel}</span></li>`;
        } else {
            html += `<li class="page-item"><button class="page-link" id="anterior" data-pag="${paginateFor}" href="${anteriorLink}" rel="prev">${anteriorLabel}</button></li>`;
        }

        // Next Page Link
        if (data['last_page'] !== data['current_page']) {
            html += `<li class="page-item"><button class="page-link" id='proximo' data-pag="${paginateFor}" href="${proximoLink}" rel="next">${proximoLabel}</button></li>`;
        } else {
            html += `<li class="page-item disabled" id='proximo' aria-disabled="true"><span class="page-link">${proximoLabel}</span></li>`;
        }

        html += '</ul ></div ><div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between"><div><p class="small text-muted">'

        html += `Mostrando <span class="fw-semibold">${data['from']}</span> a <span class="fw-semibold">${data['to']}</span> de <span class="fw-semibold">${data['total']}</span> resultados</p></div>`

        html += '</div></nav >'

        return html;
    }
}