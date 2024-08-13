<div class="col-xl-3 col-lg-4 col-6 py-2 d-flex">
    <div class="card border-0 shadow-sm overflow-hidden product-card w-100" data-id="{{$article->id}}">
        @if($article->sale_price)
        <div
            class="p-2 text-white bg-primary position-absolute start-0 top-0 z-3 rounded  mt-2 ms-2"
            style="font-size: 12px">
            تخفيض !
        </div>
        @endif
        <div class="card-img w-100 position-relative">
            <div class="add-to-cart-card">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <a href="{{route('single',$article->slug)}}">

                <img src="{{$article->getFirstMediaUrl('principal')}}" class="img-fluid w-100" alt="">
            </a>
        </div>
        <a href="{{route('single',$article->slug)}}" class="text-decoration-none ">
            <div class="card-body text-center">
                <p class="fw-medium text-muted text-truncate ">{{$article->title}}</p>
                @if($article->sale_price)
                <p class="fs-5 fw-bold text-primary"><span
                        class="mx-2 text-decoration-line-through text-orange-400 fw-normal"
                        style="font-size: 12px">  {{number_format($article->price,2,',',' ')}} </span>
                    د.م {{number_format($article->sale_price,2,',',' ')}}</p>
                @else
                <p class="fs-5 fw-bold text-primary text-decoration-none">
                    د.م {{number_format($article->price,2,',',' ')}}</p>
                @endif
            </div>
        </a>
    </div>
</div>