<div class="card">
    <div class="card-body">
        <div class="row pb-4">
            <div class="col-12">
                <div class="order-back cursor-pointer text-primary"><i class="fa fa-arrow-right"></i></div>
            </div>
            <div class="col-md-3 py-2">
                <div class="card border-0">
                    <div class="card-body">
                        <h6>رقم الطلبية</h6>
                        <div class="text-primary">
                            {{$order->number}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 py-2">
                <div class="card border-0">
                    <div class="card-body">
                        <h6>التاريخ</h6>
                        <div class="text-primary">
                            {{$order->created_at->translatedFormat('d M ,Y')}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 py-2">
                <div class="card border-0">
                    <div class="card-body">
                        <h6>المجموع</h6>
                        <div class="text-primary">
                            {{number_format($order->total+$order->shipping_fee,2,',',' ')}} د.م
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 py-2">
                <div class="card border-0">
                    <div class="card-body">
                        <h6>طريقة الدفع</h6>
                        <div class="text-primary">
                            {{$order->payment_method}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h5>تفاصيل الطلبية</h5>
        <div class="row bg-primary p-2 text-white rounded my-3">
            <div class="col-md-3 col-4">المنتج</div>
            <div class="col-3 d-none d-md-block">الكمية</div>
            <div class="col-md-3 col-4">الثمن</div>
            <div class="col-md-3 col-4">المجموع</div>
        </div>
        @foreach($order->lines as $line)
            <div class="row py-2">
                <div class="col-md-3 col-4"><a @if($line->article_id) href="{{route('single',$line->article->slug)}}" @endif>{{$line->article_title}}</a> <span class="d-md-none d-block" >x{{$line->quantity}}</span> </div>
                <div class="col-md-3 col-4 d-none d-md-block">{{$line->quantity}}</div>
                <div class="col-md-3 col-4 text-end" dir="ltr">{{number_format($line->price,2,',',' ')}} <span>د.م</span>
                </div>
                <div class="col-md-3 col-4 text-end" dir="ltr">{{number_format($line->price * $line->quantity,2,',',' ')}}
                    <span>د.م</span></div>
            </div>
        @endforeach
        <div class="border p-3 mt-4 rounded col-12 col-md-6">
            <div class="d-flex gap-2 p-2">
                <h5 class=" fw-normal">المجموع الفرعي :</h5>
                <h5 class="fw-bold text-muted" dir="ltr">{{number_format($order->total - $order->shipping_fee,2,',',' ')}} <span>د.م</span></h5>
            </div>
            <div class="d-flex gap-2 p-2">
                <h5 class="  fw-normal">الشحن :</h5>
                <h5 class="fw-bold text-muted" dir="ltr">{{number_format($order->shipping_fee,2,',',' ')}} <span>د.م</span></h5>
            </div>
            <div class="d-flex gap-2 p-2">
                <h5 class=" fw-normal">المجموع :</h5>
                <h5 class="fw-bold text-primary" dir="ltr">{{number_format($order->total,2,',',' ')}} <span>د.م</span></h5>
            </div>
        </div>
    </div>
</div>
