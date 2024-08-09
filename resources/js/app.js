const cart_change_event = new Event('cart-change')
if (localStorage.getItem('cart')){
    $('.cart .total').html(' د.م '+Number(localStorage.getItem('cart')).toLocaleString('fr',{minimumFractionDigits:2,}))
}
$(document).on('click','.add-to-cart-card',function (){
    let cart = $('.cart')
    let btn = $(this);
    let product = btn.closest('.product-card')
    let btn_html = btn.html();
    btn.html('<div class="spinner-border m-0 spinner-border-sm" role="status">' +
        '  <span class="visually-hidden">Loading...</span>' +
        '</div>')
    $.ajax({
        url:window.origin+'/add-to-cart',
        success :function (response){
            btn.html('<span class="success-cart position-absolute" ><i class="fa fa-check" ></i></span>')
            let success =$('<div class="btn-primary btn rounded-circle position-absolute translate-middle d-flex align-items-center d-flex justify-content-center" style="height: 30px;width: 30px;z-index: 50;filter: blur(1px)" ><span class="text-white" ><i class="fa fa-check" ></i></span></div>')
            let card_boundaries = cart[0].getBoundingClientRect()
            let btn_boundaries = btn[0].getBoundingClientRect()
            success.css('transition',"all ease-in-out .5s")
            success.css('top',btn_boundaries['y']+(btn_boundaries['height']/2)+window.scrollY+'px')
            success.css('left',btn_boundaries['x']+(btn_boundaries['width']/2)+window.scrollX+'px')
            $('body').append(success)
            setTimeout(()=>{
                success.css('top',card_boundaries['y']+(card_boundaries['height']/2)+window.scrollY+'px')
                success.css('left',card_boundaries['x']+(card_boundaries['width']/2)+window.scrollX+'px')
            },100)
            setTimeout(()=>{
                btn.html(btn_html)
            },200)
            setTimeout(()=>{
                success.css('opacity',0)

            },250)
            setTimeout(()=>{
                let total =localStorage.getItem('cart');

                localStorage.setItem('cart',+total+product.data('price'))
                document.dispatchEvent(cart_change_event)
            },550)
        }
    })
})
$(document).on('cart-change',function (){
    let total =localStorage.getItem('cart');
    $('.cart .total').html(' د.م '+Number( total).toLocaleString('fr',{minimumFractionDigits:2,}) )
})
