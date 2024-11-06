const cart_change_event = new Event('cart-change')
var cart_total = 0;
var cart_count = 0;
$(document).on('click', '.add-to-cart-card,.add-to-cart-card-mobile', function () {
    let cart = $('.cart:visible')
    let btn = $(this);
    let product = btn.closest('.product-card')
    let btn_html = btn.html();
    product.find('.errors').html('')
    btn.html('<div class="spinner-border m-0 spinner-border-sm" role="status">' +
        '  <span class="visually-hidden">Loading...</span>' +
        '</div>')
    $.ajax({
        url: window.origin + '/add-to-cart',
        data: {
            'article': product.data('id')
        },
        success: function (response) {
            btn.html('<span class="success-cart position-absolute" ><i class="fa fa-check" ></i></span>')
            let success = $('<div class="btn-primary btn rounded-circle position-absolute translate-middle d-flex align-items-center d-flex justify-content-center" style="height: 30px;width: 30px;z-index: 50;filter: blur(1px)" ><span class="text-white" ><i class="fa fa-check" ></i></span></div>')
            let card_boundaries = cart[0].getBoundingClientRect()
            let btn_boundaries = btn[0].getBoundingClientRect()
            success.css('transition', "all ease-in-out .5s")
            success.css('top', btn_boundaries['y'] + (btn_boundaries['height'] / 2) + window.scrollY + 'px')
            success.css('left', btn_boundaries['x'] + (btn_boundaries['width'] / 2) + window.scrollX + 'px')
            $('body').append(success)
            cart_total = response.total;
            cart_count = response.count;
            notyf.success(response.message)
            setTimeout(() => {
                success.css('top', card_boundaries['y'] + (card_boundaries['height'] / 2) + window.scrollY + 'px')
                success.css('left', card_boundaries['x'] + (card_boundaries['width'] / 2) + window.scrollX + 'px')
            }, 100)
            setTimeout(() => {
                btn.html(btn_html)
            }, 200)
            setTimeout(() => {
                success.css('opacity', 0)
            }, 250)
            setTimeout(() => {
                document.dispatchEvent(cart_change_event)
                success.remove()
            }, 550)
        },
        error: function (xhr) {
            if (xhr.status === 422){
                product.find('.errors').text(xhr.responseText)
            }else {
                notyf.error(xhr.responseText);
            }
            btn.html(btn_html)
        }
    })
})

$(document).on('click', '.out-of-stock-card, .out-of-stock-card-mobile', function () {
    let accountPanel = $('.member-order:visible');
    let btn = $(this);
    let product = btn.closest('.product-card');
    let btn_html = btn.html();
    product.find('.errors').html('');

    btn.html('<div class="spinner-border m-0 spinner-border-sm" role="status">' +
        '  <span class="visually-hidden">Loading...</span>' +
        '</div>');

    $.ajax({
        url: window.origin + '/add-to-members-order',
        data: {
            'article': product.data('id')
        },
        success: function (response) {
            btn.html('<span class="success-cart position-absolute"><i class="fa fa-check"></i></span>');
            let success = $('<div class="btn-success btn rounded-circle position-absolute translate-middle d-flex align-items-center justify-content-center" style="height: 30px;width: 30px;z-index: 50;filter: blur(1px)"><span class="text-white"><i class="fa fa-check"></i></span></div>');
            let accountPanel_boundaries = accountPanel[0] ? accountPanel[0].getBoundingClientRect() : null;
            let btn_boundaries = btn[0] ? btn[0].getBoundingClientRect() : null;

                success.css('transition', "all ease-in-out .5s");
                success.css('top', btn_boundaries.top + (btn_boundaries.height / 2) + window.scrollY + 'px');
                success.css('left', btn_boundaries.left + (btn_boundaries.width / 2) + window.scrollX + 'px');
                $('body').append(success);

                product.find('.errors').html('<h6 class="text-success d-inline mb-3 text-center">' + response.message + '</h6>');

                setTimeout(() => {
                    success.css('top', accountPanel_boundaries.top + (accountPanel_boundaries.height / 2) + window.scrollY + 'px');
                    success.css('left', accountPanel_boundaries.left + (accountPanel_boundaries.width / 2) + window.scrollX + 'px');
                }, 100);

                setTimeout(() => {
                    btn.html(btn_html);
                }, 200);

                setTimeout(() => {
                    success.css('opacity', 0);
                }, 250);

                setTimeout(() => {
                    success.remove();
                }, 550);
                btn.html(btn_html);

        },
        error: function (xhr) {
            if (xhr.status === 401) {
                window.location = window.origin+'/my-account?a=mo&i='+product.data('id')
                product.find('.errors').html('<h6 class="text-danger d-inline mb-3 text-center">' + xhr.responseJSON.message + '</h6>');
            } else {
                notyf.error(xhr.responseText);
            }
            btn.html(btn_html);
        }
    });
});

$(document).on('cart-change', function () {
    $('.cart .total').html(Number(cart_total).toLocaleString('fr', {minimumFractionDigits: 2,}))
    $('.cart .badge').html(cart_count)
})
$(document).on('click', '.password-input-group .input-group-text', function () {
    $(this).parent().find('.input-group-text').toggleClass('d-none');
    if ($(this).parent().find('input').attr('type') === 'password') {
        $(this).parent().find('input').attr('type', 'text')
    } else {
        $(this).parent().find('input').attr('type', 'password')
    }
})

$(document).on('submit', '.form-my-account', function (e) {
    e.preventDefault();
    let form = $(this);
    let url = form.attr('action')
    let btn = form.find('button');
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();
    btn.prepend($('<div class="spinner-border spinner-border-sm mx-2" role="status"><span class="visually-hidden">Loading...</span></div>'))
    btn.attr('disabled', "")
    $.ajax({
        url: url,
        data: form.serialize(),
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': form.find('[name="_token"]').val()
        },
        success: function (response) {
            btn.removeAttr('disabled')
            btn.find('.spinner-border').remove()
            form.find('[type="password"]').val("");
            notyf.success(response);
        },
        error: function (xhr) {
            btn.removeAttr('disabled')
            btn.find('.spinner-border').remove()
            if (xhr.status === 422) {
                let response = xhr.responseJSON
                for (const field in response.errors) {
                    if (response.errors.hasOwnProperty(field)) {
                        response.errors[field].forEach((error) => {
                            form.find('[name="' + field + '"]').addClass('is-invalid');
                            form.find('[name="' + field + '"]').parent().append($('<div class="invalid-feedback">' + error + '</div>'))
                        });
                    }
                }
            } else {
                notyf.error(xhr.responseText)
            }
        }
    })
})
$(document).on('click', '#logout', function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('[name="_token"]').val()
        },
        url: window.origin + '/logout',
        method: 'POST',
        success: function (response) {
            window.location.reload();
        }
    })
})

$(document).on('show.bs.offcanvas', '#cart-canvas', function () {
    let off_canvas = $(this)
    off_canvas.find('.offcanvas-body').html('<div class="d-flex align-items-center justify-content-center" ><div class="spinner-border mx-2" role="status"><span class="visually-hidden">Loading...</span></div></div>')
    $.ajax({
        url: window.origin + '/cart-canvas',
        success: function (response) {
            off_canvas.find('.offcanvas-body').html(response);
        }
    })
})
$(document).on('click', '.offcanvas-body .delete-cart-item', function () {
    let btn = $(this);
    btn.attr("disabled", "")
    let product = $(this).closest('.cart-item');
    let off_canvas_body = $(this).closest('.offcanvas-body');
    product.addClass('d-none');
    $.ajax({
        url: window.origin + '/cart-ligne',
        method: 'DELETE',
        data: {
            'item': btn.data('item')
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            notyf.success(response.message);
            cart_total = response.total;
            cart_count = response.count;
            off_canvas_body.html(response.cart)
            document.dispatchEvent(cart_change_event)
        },
        error: function (xhr) {
            product.removeClass('d-none');
            notyf.error(xhr.responseText);
            btn.removeAttr('disabled')
        }
    })
})
$(document).on('click', '.cart-item-quantity-plus', function () {
    let input = $(this).siblings('input');
    let item = $(this).closest('.cart-item').data('id');
    input.val(+input.val() + 1);
    $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url: window.origin + '/cart-item-quantity',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        data: {
            item: item,
            quantity: input.val()
        },
        success: function (response) {
            cart_total = response.total;
            cart_count = response.count;
            document.dispatchEvent(cart_change_event)
            $('.cart-container').html(response.cart)
            $('.cart-container .cart-loader').remove();
        },
        error: function (xhr) {
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})

$(document).on('click', '.cart-item-quantity-minus', function () {
    let input = $(this).siblings('input');
    let item = $(this).closest('.cart-item').data('id');
    input.val(+input.val() - 1)
    $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url: window.origin + '/cart-item-quantity',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        data: {
            item: item,
            quantity: input.val()
        },
        success: function (response) {
            cart_total = response.total;
            cart_count = response.count;
            document.dispatchEvent(cart_change_event)
            $('.cart-container').html(response.cart)
            $('.cart-container .cart-loader').remove();
        },
        error: function (xhr) {
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})
$(document).on('click', '.cart-container .delete-cart-item', function () {
    let item = $(this).closest('.cart-item').data('id');
    $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url: window.origin + '/cart-line-delete',
        method: 'DELETE',
        data: {
            'item': item
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            cart_total = response.total;
            cart_count = response.count;
            document.dispatchEvent(cart_change_event)
            $('.cart-container').html(response.cart)
            $('.cart-container .cart-loader').remove();
        },
        error: function (xhr) {
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})
$(document).on('click', '.change-city.trigger', function () {
    $('.change-city').toggleClass('d-none')
})
$(document).on('change', '.change-city select', function () {
    let city = $(this).val()
    $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url: window.origin + '/cart-city',
        method: 'POST',
        data: {
            'city': city
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('.cart-container').html(response)
            $('.cart-container .cart-loader').remove();
        },
        error: function (xhr) {
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})
$(document).on('change', '.shipping-checkbox', function () {
    if ($(this).is(':checked')) {
        $('.shipping-side').find('input:not([type="checkbox"]),select').removeAttr('disabled', '')

    } else {
        $('.shipping-side').find('input:not([type="checkbox"]),select').attr('disabled', '')
    }
})
$(document).on('change', '.payment-option input', function () {
    $('.payment-option').removeClass('active')
    $(this).closest('.payment-option').addClass('active')
});

$(document).ready(function () {
    let img = $('.card-img');
    img.css('height', img.width())
})

$(document).on('click', '.add-to-cart-card-single', function () {
    let cart = $('.cart:visible')
    let btn = $(this);
    $('.errors').html('')
    let btn_html = btn.html();
    btn.append($('<div class="spinner-border m-0 spinner-border-sm" role="status">' +
        '  <span class="visually-hidden">Loading...</span>' +
        '</div>'))
    $.ajax({
        url: window.origin + '/add-to-cart',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            article: btn.data('id'),
            quantity: btn.siblings('input').val()
        },
        success: function (response) {
            btn.siblings('input').val(1)
            btn.append($('<span class="success-cart position-absolute" ><i class="fa fa-check" ></i></span>'))
            let success = $('<div class="btn-primary btn rounded-circle position-absolute translate-middle d-flex align-items-center d-flex justify-content-center" style="height: 30px;width: 30px;z-index: 50;filter: blur(1px)" ><span class="text-white" ><i class="fa fa-check" ></i></span></div>')
            let card_boundaries = cart[0].getBoundingClientRect()
            let btn_boundaries = btn[0].getBoundingClientRect()
            success.css('transition', "all ease-in-out .5s")
            success.css('top', btn_boundaries['y'] + (btn_boundaries['height'] / 2) + window.scrollY + 'px')
            success.css('left', btn_boundaries['x'] + (btn_boundaries['width'] / 2) + window.scrollX + 'px')
            $('body').append(success)
            cart_total = response.total;
            cart_count = response.count;
            notyf.success(response.message)

            setTimeout(() => {
                success.css('top', card_boundaries['y'] + (card_boundaries['height'] / 2) + window.scrollY + 'px')
                success.css('left', card_boundaries['x'] + (card_boundaries['width'] / 2) + window.scrollX + 'px')
            }, 100)
            setTimeout(() => {
                btn.html(btn_html)
            }, 200)
            setTimeout(() => {
                success.css('opacity', 0)
            }, 250)
            setTimeout(() => {
                document.dispatchEvent(cart_change_event)
                success.remove()
            }, 550)
        },
        error: function (xhr) {
            if (xhr.status === 422){
                $('.errors').text(xhr.responseText)
            }else {
                notyf.error(xhr.responseText);
            }
            btn.html(btn_html)
        }
    })
})


$(document).on('click','.order-show-btn',function (){
    let btn  = $(this);
    let order_number = btn.data('order');
    btn.attr('disabled','')
    $.ajax({
        url:window.origin+'/orders/'+order_number,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response){
            $('.orders-list').addClass('d-none');
            $('.order-show').removeClass('d-none')
            $('.order-show').html(response)
            btn.removeAttr('disabled')
        },
        error: function (xhr){
            notyf.error(xhr.responseText)
            btn.removeAttr('disabled')
        }
    })
})
$(document).on('click','.order-back',function (){
    $('.orders-list').removeClass('d-none');
    $('.order-show').addClass('d-none')
})

$(document).on('click','.search-nav-mobile',function (){
    let btn = $(this);
    let input = btn.siblings('input');
    if (input.val()){
        window.location = window.origin+'/shop/search/'+input.val()
    }
})
$('.nav-link.dropdown-toggle').click(function (){
    $(this).siblings('.dropdown-menu').toggleClass('d-block')
})
$('.search-close').click(function (){
    $(this).parent().fadeOut()
})
$('.search-open').click(function (){
    $('.search-container').fadeIn()
})
$(document).on('submit','#global-search-form',function (e){
    e.preventDefault();
    let input = $(this).find('input');
    if (input.val()){
        window.location = window.origin+'/shop/search/'+input.val()
    }
})

// ---------- checkout ---------
$(document).on('submit','#checkout-form',function (event){
    event.preventDefault();
    let form = $(this);
    $('.invalid-feedback').html('')
    $('.is-invalid').removeClass('is-invalid')
    form.append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url:form.attr('action'),
        data:form.serialize(),
        method:'POST',
        success:function (response){
            $('body').append(response)
        },
        error:function (xhr){
            $('.cart-loader').remove();
            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                for (const [key,value] of Object.entries(errors)){
                    $(`[name="${key}"]`).addClass('is-invalid')
                    $(`[name="${key}"]`).siblings('.invalid-feedback').html(value)
                }
            }else {
                notyf.error("حدث خطأ أثناء العملية")
            }
        }
    })
})
