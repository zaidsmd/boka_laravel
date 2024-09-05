<div class="col-xl-3 col-lg-4 col-6 py-2 d-flex">
    <div class="card border-0 shadow-sm overflow-hidden product-card w-100" data-id="{{$article->id}}">
        @if($article->sale_price)
            <div
                class="p-2 text-white bg-primary position-absolute start-0 top-0 z-3 rounded mt-2 ms-2"
                style="font-size: 12px">
                تخفيض !
            </div>
        @endif

        <div class="card-img w-100 position-relative">
            @if($article->quantite > 0)
                <div class="add-to-cart-card d-md-block d-none">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            @endif
            @if($article->quantite < 0)
                <div class="out-of-stock-card d-md-block d-none">
                    <button class="btn btn-warning out-of-stock-btn">
                        <i class="fa-solid fa-bell"></i> الطلب عند الوصول
                    </button>
                </div>
            @endif

            <a href="{{route('single',$article->slug)}}">
                <img src="{{$article->getFirstMediaUrl('principal')}}" class="img-fluid w-100" alt="">
            </a>
        </div>

        <a href="{{route('single',$article->slug)}}" class="text-decoration-none">
            <div class="card-body text-center">
                <p class="fw-medium text-muted text-truncate m-0">{{$article->title}}</p>
                @if($article->sale_price)
                    <p class="fs-5 fw-bold text-primary m-0"><span
                            class="mx-2 text-decoration-line-through text-orange-400 fw-normal"
                            style="font-size: 12px">  {{number_format($article->price,2,',',' ')}} </span>
                        د.م {{number_format($article->sale_price,2,',',' ')}}</p>
                @else
                    <p class="fs-5 fw-bold text-primary text-decoration-none m-0">
                        د.م {{number_format($article->price,2,',',' ')}}</p>
                @endif
            </div>
        </a>

        <div class="errors text-center py-2"></div>

        @if($article->quantite > 0)
            <div class="btn btn-primary d-md-none text-white mt-auto mb-3  mx-3  add-to-cart-card-mobile d-block">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            @elseif($article->quantite < 0)
            <h6 class="text-danger d-inline mb-3 text-center">سيتوفر قريبا</h6>
            <div class="btn btn-success d-md-none text-white mx-3 my-2 out-of-stock-card-mobile d-block " style="font-size: small">
                <i class="fa-solid fa-bell ms-2"></i>الطلب عند الوصول
            </div>
            @else
                <h6 class="text-danger d-inline mb-3 text-center">هذا المنتج غير متوفر</h6>
            @endif
    </div>
</div>
