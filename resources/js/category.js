var next = '';
var current_page = '';
var total = 0;
var per_page_count = 12;
var skeleton = '<div class="col-xl-3 col-lg-4 col-6 py-2 d-flex skeleton-wrapper"><div class="card border-0 shadow-sm overflow-hidden product-card w-100" data-id=""><div class="skeleton-sale-price"></div><div class="card-img w-100 position-relative"><div class="skeleton-img"></div></div><div class="card-body text-center"><p class="skeleton-title"></p><p class="skeleton-price"></p></div></div></div>';
function skeletonPaster(count){
    let html = '';
    for (let i = 0; i <count ; i++) {
        html+=skeleton
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

    var $cardImg = $('<div>', { class: 'card-img w-100 position-relative' });

    var $cartIcon = $('<div>', { class: 'add-to-cart-card d-sm-block d-none' }).append($('<i>', { class: 'fa-solid fa-cart-shopping' }));
    $cardImg.append($cartIcon);

    var $imageLink = $('<a>', { href: window.origin+`/product/${article.slug}` });
    var $image = $('<img>', {
        src: article.media_url,
        class: 'img-fluid w-100',
        alt: article.title
    });
    $imageLink.append($image);
    $cardImg.append($imageLink);
    $card.append($cardImg);

    var $cardBody = $('<div>', { class: 'card-body text-center' });
    var $title = $('<p>', { class: 'fw-medium text-muted text-truncate m-0', text: article.title });
    $cardBody.append($title);

    if (article.sale_price) {
        var $price = $('<p>', { class: 'fs-5 fw-bold text-primary' });
        var $originalPrice = $('<span>', {
            class: 'mx-2 text-decoration-line-through text-orange-400 fw-normal',
            style: 'font-size: 12px',
            text: ` ${article.price.toLocaleString('ar-MA', { minimumFractionDigits: 2 })} `
        });
        $price.append($originalPrice);
        $price.append(`د.م ${article.sale_price.toLocaleString('ar-MA', { minimumFractionDigits: 2 })}`);
        $cardBody.append($price);
    } else {
        var $price = $('<p>', {
            class: 'fs-5 fw-bold text-primary text-decoration-none',
            text: `د.م ${article.price.toLocaleString('ar-MA', { minimumFractionDigits: 2 })}`
        });
        $cardBody.append($price);
    }
    $card.append($('<a>', { href: window.origin+`/product/${article.slug}`, class: 'text-decoration-none' }).append($cardBody));
    $card.append($(' <div class="btn btn-primary add-to-cart-card-mobile d-md-none d-block text-white mt-auto mb-3 mx-3" ><i class="fa-solid fa-cart-shopping"></i></div>'))
    $wrapper.append($card)
    return $wrapper;
}
function populateProductCards(data){
    let cards = $('.shop-cards-container').clone();
    cards.find('.skeleton-wrapper').remove();
    if (data.length){
        data.forEach(article=>{
            cards.append(createProductCard(article));
        })
    }else {
        cards.append($('<div class="d-flex flex-column align-items-center justify-content-center" ><i class="fa fa-times text-primary fa-9x "></i><p>لم يتم العثور على أي منتجات تتوافق مع إختيارك.\n</p></div>'))
    }
    $('.shop-cards-container').replaceWith(cards)
}
function fetchProducts(count,url =window.origin + '/categories-ajax'){
    $('.shop-cards-container').append(skeletonPaster(count))
    $.ajax({
        url: url ,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            category:$('#_cat').val()
        },
        success: function (response) {
            populateProductCards(response.data);
            let img = $('.card-img');
            img.css('height',img.width());
            next = response.links.next
            fetchingScroll = false;
            current_page = response.meta.current_page;
            total = response.meta.total;
        }
    })
}
$(document).ready(function () {
    fetchProducts(per_page_count)
})
var fetchingScroll = false;
$(window).scroll(function() {
    if (!fetchingScroll && $(window).scrollTop() + $(window).height() >= $(document).height() - 200 && next) {
        fetchingScroll = true;
        let tofetch = (total - (current_page * per_page_count)) < per_page_count ? (total - (current_page * per_page_count)) : 10;
        fetchProducts(tofetch,next)
    }
});

$(document).on('change','.filter',function (){
    if (!fetchingScroll){
        fetchingScroll = true;
        $('.shop-cards-container').html('').append(skeletonPaster(per_page_count))
        fetchProducts(per_page_count)
    }
})
$(document).on('click','.search',function (){
    if (!fetchingScroll){
        fetchingScroll = true;
        $('.shop-cards-container').html('').append(skeletonPaster(per_page_count))
        fetchProducts(per_page_count)
    }
})
