document.addEventListener('DOMContentLoaded', async function (event) {
    await loadPaginate()

    document.addEventListener('click', function (event) {
        if (event.target && event.target.id === 'proximo') {
            alert('adada')
            fetch(event.target.getAttribute('href'), {
                method: 'GET',
            })
                .then(response => response.json())
                .then(function (data) {
                    let sectionProducts = document.querySelector('section#products');
                    sectionProducts.innerHTML = '';

                    data['data'].forEach(product => {
                        sectionProducts.innerHTML += `<a style='font-size:20px;' href='/produto/${product['id']}' class='text-dark'>${product['name']}</a><br>`;
                    });

                    sectionProducts.innerHTML += paginateButtons(data);
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

            let sectionProducts = document.querySelector('section#products');
            let sectionPurchases = document.querySelector('section#purchases');

            data['products']['data'].forEach(product => {
                sectionProducts.innerHTML += `<a style='font-size:20px;' href='/produto/${product['id']}' class='text-dark'>${product['name']}</a><br>`;
            });

            data['purchases']['data'].forEach(purchases => {
                sectionPurchases.innerHTML += `<a style='font-size:20px;' href='/produto/${purchases['product_id']}' class='text-dark'>${purchases['name']}</a><br>`;
            });

            sectionProducts.innerHTML += paginateButtons(data['products']);
        })
}


function paginateButtons(data) {
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
            html += `<li class="page-item"><a class="page-link" href="${anteriorLink}" rel="prev">${anteriorLabel}</a></li>`;
        }

        // Next Page Link
        if (data['last_page'] !== data['current_page']) {
            html += `<li class="page-item"><button class="page-link" id='proximo' href="${proximoLink}" rel="next">${proximoLabel}</button></li>`;
        } else {
            html += `<li class="page-item disabled" id='proximo' aria-disabled="true"><span class="page-link">${proximoLabel}</span></li>`;
        }

        //     </ul >
        // </div >

        //     <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        //         <div>
        //             <p class="small text-muted">
        //                 {!!__('Showing')!!}
        //                 <span class="fw-semibold">{{ $paginator-> firstItem()}}</span>
        //                 {!!__('to')!!}
        //                 <span class="fw-semibold">{{ $paginator-> lastItem()}}</span>
        //                 {!!__('of')!!}
        //                 <span class="fw-semibold">{{ $paginator-> total()}}</span>
        //                 {!!__('results')!!}
        //             </p>
        //         </div>

        //         <div>
        //             <ul class="pagination">
        //                 {{-- Previous Page Link --}}
        //                 @if ($paginator->onFirstPage())
        //                 <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
        //                     <span class="page-link" aria-hidden="true">&lsaquo;</span>
        //                 </li>
        //                 @else
        //                 <li class="page-item">
        //                     <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
        //                 </li>
        //                 @endif

        //                 {{-- Pagination Elements --}}
        //                 @foreach ($elements as $element)
        //                 {{-- "Three Dots" Separator --}}
        //                 @if (is_string($element))
        //                 <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        //                 @endif

        //                 {{-- Array Of Links --}}
        //                 @if (is_array($element))
        //                         @foreach ($element as $page => $url)
        //                             @if ($page == $paginator->currentPage())
        //                 <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
        //                 @else
        //                 <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
        //                 @endif
        //                 @endforeach
        //                 @endif
        //                 @endforeach

        //                 {{-- Next Page Link --}}
        //                 @if ($paginator->hasMorePages())
        //                 <li class="page-item">
        //                     <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
        //                 </li>
        //                 @else
        //                 <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
        //                     <span class="page-link" aria-hidden="true">&rsaquo;</span>
        //                 </li>
        //                 @endif
        //     </ul>
        // </div>
        html += '</div></nav >'

        return html;
    }

}