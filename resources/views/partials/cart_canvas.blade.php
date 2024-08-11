@if(cart()->cart_lignes()->count())
    <div class="row p-3 ">
        @foreach(cart()->cart_lignes as $line)
            <div class="col-12 my-2  py-2  border-bottom cart-item">
                <div class="d-flex justify-content-between">
                    <div class="col-3">
                        <img src="https://picsum.photos/id/{{$line->article->id+100}}/300/300" class="img-fluid w-100"
                             alt="">
                    </div>
                    <div>
                        <h5 class="text-primary">{{$line->article->title}}</h5>
                        <div class="d-flex gap-1">
                            <p>{{$line->quantity}}</p>
                            <p>x</p>
                            <p>{{number_format($line->article->sale_price?? $line->article->price,2,',', ' ')}}</p>
                            <p>د.م</p>
                        </div>
                    </div>
                    <button class="btn text-danger border-0 fs-5 delete-cart-item " data-item="{{$line->id}}" ><i
                            class="fa-regular fa-circle-xmark"></i></button>
                </div>
            </div>
        @endforeach
        <div class="col-12  py-2  border-bottom my-2">
            <div class="d-flex gap-2">
                <h4 class="text-primary">المجموع:</h4>
                <h4 class="text-primary" dir="ltr">{{number_format(cart()->total,2,',',' ')}}</h4>
                <h4 class="text-primary">د.م</h4>
            </div>
        </div>
    </div>
    <div class="col-6">
        <a href="{{route('cart.show')}}" class="btn btn-primary text-white">عرض السلة</a>
    </div>
@else
    <div class="d-flex align-items-center justify-content-center">
       <div class="text-center">
           <h1 class="text-primary"><i class="fa-solid fa-cart-shopping"></i></h1>
           عربة التسوق فارغة
       </d>
    </div>
@endif
