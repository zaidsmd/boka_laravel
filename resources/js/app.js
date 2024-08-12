const cart_change_event = new Event('cart-change')
var cart_total = 0;
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
        data: {
            'article':product.data('id')
        },
        success :function (response){
            btn.html('<span class="success-cart position-absolute" ><i class="fa fa-check" ></i></span>')
            let success =$('<div class="btn-primary btn rounded-circle position-absolute translate-middle d-flex align-items-center d-flex justify-content-center" style="height: 30px;width: 30px;z-index: 50;filter: blur(1px)" ><span class="text-white" ><i class="fa fa-check" ></i></span></div>')
            let card_boundaries = cart[0].getBoundingClientRect()
            let btn_boundaries = btn[0].getBoundingClientRect()
            success.css('transition',"all ease-in-out .5s")
            success.css('top',btn_boundaries['y']+(btn_boundaries['height']/2)+window.scrollY+'px')
            success.css('left',btn_boundaries['x']+(btn_boundaries['width']/2)+window.scrollX+'px')
            $('body').append(success)
            console.log(response);
            cart_total = response.total;
            notyf.success(response.message)
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
                document.dispatchEvent(cart_change_event)
                success.remove()
            },550)
        },
        error: function (xhr){
            notyf.error(xhr.responseText);
            btn.html(btn_html)
        }
    })
})
$(document).on('cart-change',function (){
    $('.cart .total').html(Number( cart_total).toLocaleString('fr',{minimumFractionDigits:2,}) )
})
$(document).on('click','.password-input-group .input-group-text',function (){
    $(this).parent().find('.input-group-text').toggleClass('d-none');
    if ($(this).parent().find('input').attr('type')==='password'){
        $(this).parent().find('input').attr('type','text')
    }else {
        $(this).parent().find('input').attr('type','password')
    }
})

$(document).on('submit','.form-my-account',function (e){
    e.preventDefault();
    let form = $(this);
    let url = form.attr('action')
    let btn = form.find('button');
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();
    btn.prepend($('<div class="spinner-border spinner-border-sm mx-2" role="status"><span class="visually-hidden">Loading...</span></div>'))
    btn.attr('disabled',"")
    $.ajax({
        url:url,
        data:form.serialize(),
        method:"POST",
        headers:{
            'X-CSRF-TOKEN':form.find('[name="_token"]').val()
        },
        success:function (response) {
            btn.removeAttr('disabled')
            btn.find('.spinner-border').remove()
            form.find('[type="password"]').val("");
            notyf.success(response);

        },
        error:function (xhr){
            btn.removeAttr('disabled')
            btn.find('.spinner-border').remove()
            if (xhr.status === 422){
                let response = xhr.responseJSON
                for (const field in response.errors) {
                    if (response.errors.hasOwnProperty(field)) {
                        response.errors[field].forEach((error) => {
                            form.find('[name="'+field+'"]').addClass('is-invalid');
                            form.find('[name="'+field+'"]').parent().append($('<div class="invalid-feedback">'+error+'</div>'))
                        });
                    }
                }
            }else{
                notyf.error(xhr.responseText)
            }
        }
    })
})
$(document).on('click','#logout',function (){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('[name="_token"]').val()
        },
        url:window.origin+'/logout',
        method:'POST',
        success:function (response){
            window.location.reload();
        }
    })
})

$(document).on('show.bs.offcanvas',function (){
    let off_canvas = $(this)
    off_canvas.find('.offcanvas-body').html('<div class="d-flex align-items-center justify-content-center" ><div class="spinner-border mx-2" role="status"><span class="visually-hidden">Loading...</span></div></div>')
    $.ajax({
        url:window.origin+'/cart-canvas',
        success: function (response){
            off_canvas.find('.offcanvas-body').html(response);
        }
    })
})
$(document).on('click','.offcanvas-body .delete-cart-item',function (){
    let btn = $(this);
    btn.attr("disabled","")
    let product = $(this).closest('.cart-item');
    let off_canvas_body = $(this).closest('.offcanvas-body');
    product.addClass('d-none');
    $.ajax({
        url:window.origin+'/cart-ligne',
        method:'DELETE',
        data:{
            'item':btn.data('item')
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function (response){
            notyf.success(response.message);
            cart_total = response.total;
            off_canvas_body.html(response.cart)
            document.dispatchEvent(cart_change_event)
        },
        error:function (xhr){
            product.removeClass('d-none');
            notyf.error(xhr.responseText);
            btn.removeAttr('disabled')
        }
    })
})
$(document).on('click','.cart-item-quantity-plus',function (){
   let input = $(this).siblings('input');
   let item  = $(this).closest('.cart-item').data('id');
   input.val(+input.val()+1);
   $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url: window.origin+'/cart-item-quantity',
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:'POST',
        data:{
            item:item,
            quantity : input.val()
        },
        success:function (response){
            cart_total = response.total;
            document.dispatchEvent(cart_change_event)
            $('.cart-container').html(response.cart)
            $('.cart-container .cart-loader').remove();
        },
        error:function (xhr){
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})

$(document).on('click','.cart-item-quantity-minus',function (){
    let input = $(this).siblings('input');
    let item  = $(this).closest('.cart-item').data('id');
    input.val(+input.val()-1)
    $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url: window.origin+'/cart-item-quantity',
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:'POST',
        data:{
            item:item,
            quantity : input.val()
        },
        success:function (response){
            cart_total = response.total;
            document.dispatchEvent(cart_change_event)
            $('.cart-container').html(response.cart)
            $('.cart-container .cart-loader').remove();
        },
        error:function (xhr){
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})
$(document).on('click','.cart-container .delete-cart-item',function (){
    let item  = $(this).closest('.cart-item').data('id');
    $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url:window.origin+'/cart-line-delete',
        method:'DELETE',
        data:{
            'item':item
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function (response){
            cart_total = response.total;
            document.dispatchEvent(cart_change_event)
            $('.cart-container').html(response.cart)
            $('.cart-container .cart-loader').remove();
        },
        error:function (xhr){
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})
$(document).on('click','.change-city.trigger',function (){
    $('.change-city').toggleClass('d-none')
})
$(document).on('change','.change-city select',function (){
    let city = $(this).val()
    $('.cart-container').append($('<div class="position-absolute top-0 bottom-0 end-0 start-0 text-primary rounded d-flex align-items-center justify-content-center cart-loader" ><div class="spinner-border"></div></div>'))
    $.ajax({
        url:window.origin+'/cart-city',
        method:'POST',
        data:{
            'city':city
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function (response){
            $('.cart-container').html(response)
            $('.cart-container .cart-loader').remove();
        },
        error:function (xhr){
            notyf.error(xhr.responseText);
            $('.cart-container .cart-loader').remove();
        }
    })
})


// $(document).on('click', '.__datatable-edit-modal', function () {
//     if (processing === 0) {
//         processing = 1;
//         let html = $(this).html();
//         $(this).attr('disabled', '').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
//         let url = $(this).data('url');
//         let target = '#' + $(this).data('target');
//         $.ajax({
//             url: url, method: 'GET', success: response => {
//                 processing = 0;
//                 $(this).removeAttr('disabled').html(html)
//                 $(target).find('.modal-content').html(response);
//                 $(target).modal('show');
//             }, error: xhr => {
//                 processing = 0;
//                 $(this).removeAttr('disabled').html(html)
//                 if(xhr.status !== undefined) {
//                     if (xhr.status === 403) {
//                         toastr.warning("Vous n'avez pas l'autorisation nécessaire pour effectuer cette action");
//                         return
//                     }
//                 }
//                 toastr.error('Un erreur est produit')
//             }
//         })
//     }
//
// })

// $(document).on('click', '.sa-warning', function () {
//     Swal.fire({
//         title: "Est-vous sûr?",
//         text: "Vous ne pourrez pas revenir en arrière !",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonText: "Oui, supprimez!",
//         buttonsStyling: false,
//         customClass: {
//             confirmButton: 'btn btn-soft-danger mx-2', cancelButton: 'btn btn-soft-secondary mx-2',
//         },
//         didOpen: () => {
//             $('.btn').blur()
//         },
//         preConfirm: async () => {
//             Swal.showLoading();
//             try {
//                 const [response] = await Promise.all([new Promise((resolve, reject) => {
//                     $.ajax({
//                         url: $(this).data('url'), method: 'DELETE', headers: {
//                             'X-CSRF-TOKEN': __csrf_token
//                         }, success: resolve, error: (_, jqXHR) => reject(_)
//                     });
//                 })]);
//
//                 return response;
//             } catch (jqXHR) {
//                 let errorMessage = "Une erreur s'est produite lors de la demande.";
//                 if(jqXHR.status !== undefined) {
//                     if (jqXHR.status === 404) {
//                         errorMessage = "La ressource n'a pas été trouvée.";
//                     }
//                     if (jqXHR.status === 403) {
//                         errorMessage = "Vous n'avez pas l'autorisation nécessaire pour effectuer cette action";
//                     }
//                 }
//                 Swal.fire({
//                     title: 'Erreur',
//                     text: errorMessage,
//                     icon: 'error',
//                     buttonsStyling: false,
//                     confirmButtonText: 'OK',
//                     customClass: {
//                         confirmButton: 'btn btn-soft-danger mx-2',
//                     },
//                 });
//
//                 throw jqXHR;
//             }
//         }
//     }).then((result) => {
//         if (result.isConfirmed) {
//             if (result.value) {
//                 Swal.fire({
//                     title: 'Succès',
//                     text: result.value,
//                     icon: 'success',
//                     buttonsStyling: false,
//                     confirmButtonText: 'OK',
//                     customClass: {
//                         confirmButton: 'btn btn-soft-success mx-2',
//                     },
//                 }).then(result => {
//                     if (typeof table != 'undefined') {
//                         table.ajax.reload();
//                     } else {
//                         location.reload();
//                     }
//                 });
//             } else {
//                 Swal.fire({
//                     title: 'Erreur',
//                     text: "Une erreur s'est produite lors de la demande.",
//                     icon: 'error',
//                     buttonsStyling: false,
//                     confirmButtonText: 'OK',
//                     customClass: {
//                         confirmButton: 'btn btn-soft-danger mx-2',
//                     },
//                 });
//             }
//         }
//     })
// });
