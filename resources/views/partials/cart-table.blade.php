@if(cart()->cart_lignes()->count())
    <div class="d-sm-flex p-2 bg-white py-3 rounded d-none">
        <div class="col-5 fw-bold">
            المنتج
        </div>
        <div class="col-2 fw-bold">الثمن</div>
        <div class="col-2 fw-bold">الكمية</div>
        <div class="col-2 fw-bold">المجموع</div>
    </div>
    @foreach($cart->cart_lignes as $ligne)
        <div class="d-flex p-3 bg-white rounded my-3 align-items-center cart-item" data-id="{{$ligne->id}}">
            <div class="col-5">
                <div class="d-flex justify-content-between ps-5 align-items-center">
                    <span class="delete-cart-item text-muted"> <span class="fa fa-times"></span> </span>
                    <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px;height: 50px" >
                        <img src="https://picsum.photos/id/{{$ligne->article->id+100}}/300/300" class="img-fluid w-100"
                             alt="">
                    </div>
                    <h5 class="text-orange-300 fw-normal">
                        {{$ligne->article->title}}
                    </h5>
                </div>
            </div>
            <div class="col-2">
                د.م
                {{number_format($ligne->article->sale_price?? $ligne->article->price,2,',',' ')}}
            </div>
            <div class="col-2">
                <div class="input-group justify-content-end   ">
                    <span class="input-group-text cart-item-quantity-plus">+</span>
                    <input type="number" style="max-width: 50px !important;" value="{{$ligne->quantity}}" class="form-control ">
                    <span class="input-group-text cart-item-quantity-minus">-</span>
                </div>
            </div>
            <div class="col-2">
                <h5 class="text-orange-300 fw-normal text-end" dir="ltr" >
                    {{number_format($ligne->total,2,',',' ')}}
                    <span class="mx-2" >د.م</span>
                </h5>
            </div>
        </div>
        <div class="col-4 py-2">
            <div class="bg-white p-4 d-flex rounded">
                <h5 class="col-6 m-0 text-muted">المجموع</h5>
                <h5 class="col-6 m-0 text-end" dir="ltr">{{number_format(cart()->total,2,',',' ')}}                <span>  د.م</span>
                </h5>
            </div>
        </div>
    @endforeach

@else
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <h1 class="text-primary"><i class="fa-solid fa-cart-shopping"></i></h1>
                        عربة التسوق فارغة
                        </d>
                    </div>
            </div>
        </div>
    </div>
@endif
