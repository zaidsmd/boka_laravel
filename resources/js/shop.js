var next = '';
var current_page = '';
var total = 0;
var per_page_count = 12;
var skeleton = '<div class="col-xl-3 col-lg-4 col-6 py-2 d-flex skeleton-wrapper"><div class="card border-0 shadow-sm overflow-hidden product-card w-100" data-id=""><div class="skeleton-sale-price"></div><div class="card-img w-100 position-relative"><div class="skeleton-img"></div></div><div class="card-body text-center"><p class="skeleton-title"></p><p class="skeleton-price"></p></div></div></div>';

function skeletonPaster(count) {
    let html = '';
    for (let i = 0; i < count; i++) {
        html += skeleton
    }
    return $(html)
}

function createProductCard(article) {
    let $wrapper = $('<div class="col-xl-3 col-lg-4 col-6 py-2 d-flex"></div>')
    var $card = $('<div>', {
        class: 'card border-0 shadow-sm overflow-hidden product-card w-100',
        'data-id': article.id
    });

    if (article.sale_price) {
        var $saleBadge = $('<div>', {
            class: 'p-2 text-white bg-primary position-absolute start-0 top-0 z-3 rounded mt-2 ms-2',
            style: 'font-size: 12px',
            text: 'تخفيض !'
        });
        $card.append($saleBadge);
    }

    var $cardImg = $('<div>', {class: 'card-img w-100 position-relative'});

    var $cartIcon = $('<div>', {class: 'add-to-cart-card d-sm-block d-none'}).append($('<i>', {class: 'fa-solid fa-cart-shopping'}));
    if (article.quantity > 0) {
        $cardImg.append($cartIcon);
    }else if(article.quantity < 0){
        $cardImg.append($(' ' +
            ' <div class="out-of-stock-card d-md-block d-none">\n' +
            '                    <button class="btn btn-warning out-of-stock-btn">\n' +
            '                        <i class="fa-solid fa-bell"></i> الطلب عند الوصول\n' +
            '                    </button>\n' +
            '                </div>' ))
        // '<div class="btn btn-primary add-to-cart-card-mobile d-md-none d-block text-white mt-auto mb-3 mx-3" ><i class="fa-solid fa-cart-shopping"></i></div>'))
    }

    var $imageLink = $('<a>', {href: window.origin + `/product/${article.slug}`});
    var $image = $('<img>', {
        src: article.media_url,
        class: 'img-fluid w-100',
        alt: article.title
    });
    $imageLink.append($image);
    $cardImg.append($imageLink);
    $card.append($cardImg);

    var $cardBody = $('<div>', {class: 'card-body text-center'});
    var $title = $('<p>', {class: 'fw-medium text-muted text-truncate m-0', text: article.title});
    $cardBody.append($title);

    if (article.sale_price) {
        var $price = $('<p>', {class: 'fs-5 fw-bold text-primary'});
        var $originalPrice = $('<span>', {
            class: 'mx-2 text-decoration-line-through text-orange-400 fw-normal',
            style: 'font-size: 12px',
            text: ` ${article.price.toLocaleString('ar-MA', {minimumFractionDigits: 2})} `
        });
        $price.append($originalPrice);
        $price.append(`د.م ${article.sale_price.toLocaleString('ar-MA', {minimumFractionDigits: 2})}`);
        $cardBody.append($price);
    } else {
        var $price = $('<p>', {
            class: 'fs-5 fw-bold text-primary text-decoration-none',
            text: `د.م ${article.price.toLocaleString('ar-MA', {minimumFractionDigits: 2})}`
        });
        $cardBody.append($price);
    }
    $card.append($('<a>', {
        href: window.origin + `/product/${article.slug}`,
        class: 'text-decoration-none'
    }).append($cardBody));
    $card.append($('<div class="errors text-danger text-center py-2"></div>\n'))
    if (article.quantity > 0) {
        $card.append($(' <div class="btn btn-primary add-to-cart-card-mobile d-md-none d-block text-white mt-auto mb-3 mx-3" ><i class="fa-solid fa-cart-shopping"></i></div>'))
    }else if (article.quantity < 0){
        $card.append($('   <h6 class="text-danger d-inline mb-3 text-center">سيتوفر قريبا</h6>\n' +
            '            <div class="btn btn-success d-md-none text-white mx-3 my-2 out-of-stock-card-mobile d-block " >\n' +
            '                <i class="fa-solid fa-bell ms-2"></i>الطلب عند الوصول\n' +
            '            </div>' ))
    }else {
        $card.append($(' <h6 class="text-danger d-inline mb-3 text-center" >هذا المنتج غير متوفر</h6>'))
    }
    $wrapper.append($card)
    return $wrapper;
}

function populateProductCards(data) {
    let cards = $('.shop-cards-container').clone();
    cards.find('.skeleton-wrapper').remove();
    if (data.length) {
        data.forEach(article => {
            cards.append(createProductCard(article));
        })
    } else {
        cards.append($('<div class="d-flex flex-column align-items-center justify-content-center" ><i class="fa fa-times text-primary fa-9x "></i><p>لم يتم العثور على أي منتجات تتوافق مع إختيارك.\n</p></div>'))
    }
    $('.shop-cards-container').replaceWith(cards)
}

function fetchProducts(count, url = window.origin + '/shop-ajax') {
    $('.shop-cards-container').html('').append(skeletonPaster(count))
    let categories = [];
    let tags = [];
    $('[name=categories]:checked').each(function () {
        categories.push($(this).val());
    })
    $('[name=tags]:checked').each(function () {
        tags.push($(this).val());
    })
    $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            search: $('#search-input').val(),
            min: $('#min').val(),
            max: $('#max').val(),
            categories: categories,
            sale: $('#sale:checked').val(),
            tags: tags,
            sort: $('#sort-desktop').val()
        },
        success: function (response) {
            populateProductCards(response.data);
            if (response.data.length) {
                $('.pagination-container').html('').append(generatePagination(response.meta.links))

            } else {
                $('.pagination-container').html('')
            }
            let img = $('.card-img');
            img.css('height', img.width());
            next = response.links.next
            fetchingScroll = false;
            current_page = response.meta.current_page;
            total = response.meta.total;
            updateTagCounts(response.tagCounts,response.catCounts)
            $('.filter,.search').removeAttr('disabled')
        }
    })
}

function updateTagCounts(tagCounts,categoryCounts) {
    const tagCountsMap = new Map(tagCounts.map(tag => [tag.slug, tag.article_count]));

// Process all tags
    $('input[name=tags]').each(function () {
        const $checkbox = $(this);
        const tagSlug = $checkbox.attr('id').replace('tag-', '');

        // Get the count from the map or default to 0
        const count = tagCountsMap.get(tagSlug) || 0;

        // Update the label associated with the checkbox
        const $label = $checkbox.siblings('label');
        if ($label.length) {
            $label.find('.text-muted').html(`(${count})`);
        }
    });

    const categoryCountsMap = new Map(categoryCounts.map(cat=>[cat.slug,cat.article_count]))

    $('input[name=categories]').each(function () {
        const $checkbox = $(this);
        const catSlug = $checkbox.attr('id').replace('cat-', '');
        const count = categoryCountsMap.get(catSlug) || 0;

        const $label = $checkbox.siblings('label');
        if ($label.length) {
            $label.find('.text-muted').html(`(${count})`);
        }
    });

}

function generatePagination(pages) {
    let pagination = $('<ul class="pagination justify-content-center"></ul>');
    const totalPages = pages.length;
    const currentPageIndex = pages.findIndex(page => page.active);

    // Add "Previous" button
    if (currentPageIndex > 1) {
        pagination.append(`<li class="page-item"><a class="page-link" data-href="${pages[0].url}">${pages[0].label}</a></li>`);
    }

    // First pages
    // if (currentPageIndex > 2) {
    //     pagination.append(`<li class="page-item"><a class="page-link" data-href="${pages[1].url}">${pages[1].label}</a></li>`);
    //     pagination.append('<li class="page-item"><span class="page-link disabled">...</span></li>');
    // }

    // Middle pages
    for (let i = Math.max(1, currentPageIndex - 1); i <= Math.min(currentPageIndex + 1, totalPages - 2); i++) {
        let li = $('<li class="page-item"></li>');
        let a = $('<a class="page-link"></a>').text(pages[i].label).attr('data-href', pages[i].url);

        if (pages[i].active) {
            li.addClass('active');
        }
        li.append(a);
        pagination.append(li);
    }

    // Ellipsis after middle pages if necessary
    if (currentPageIndex < totalPages - 3) {
        pagination.append('<li class="page-item"><span class="page-link disabled">...</span></li>');
    }

    // Last pages
    if (currentPageIndex < totalPages - 3) {
        pagination.append(`<li class="page-item"><a class="page-link" data-href="${pages[totalPages - 2].url}">${pages[totalPages - 2].label}</a></li>`);
    }

    // Add "Next" button
    if (currentPageIndex < totalPages - 2) {
        pagination.append(`<li class="page-item"><a class="page-link" data-href="${pages[totalPages - 1].url}">${pages[totalPages - 1].label}</a></li>`);
    }

    return pagination;
}


$(document).on('click', '.page-link', function () {
    let btn = $(this);
    var fetchingScroll = false;
    fetchProducts(per_page_count, btn.data('href'))
})
$(document).ready(function () {
    fetchProducts(per_page_count)
})
var fetchingScroll = false;
// $(window).scroll(function() {
//     if (!fetchingScroll && $(window).scrollTop() + $(window).height() >= $(document).height() - 200 && next) {
//         fetchingScroll = true;
//         let tofetch = (total - (current_page * per_page_count)) < per_page_count ? (total - (current_page * per_page_count)) : 10;
//         fetchProducts(tofetch,next)
//     }
// });


$(document).on('change', '.filter', function () {
    $('.filter').attr('disabled', '')
    if (!fetchingScroll) {
        fetchingScroll = true;
        $('.shop-cards-container').html('').append(skeletonPaster(per_page_count))
        fetchProducts(per_page_count)
    }
})
$(document).on('click', '.search', function () {
    $('.filter,.search').attr('disabled', '')
    if (!fetchingScroll) {
        fetchingScroll = true;
        $('.shop-cards-container').html('').append(skeletonPaster(per_page_count))
        fetchProducts(per_page_count)
    }
})
$(document).on("show.bs.offcanvas", "#filters-canvas", function () {
    if (!$(this).find('.replaced').length) {
        $(this).find('#canvas-replace').html($('.filters-container').html());
        $(this).find('#canvas-replace').addClass('replaced')
        $('.filters-container').html('')
    }
})
