@extends('layouts.main')
@section('page')
    <div class="row">
        <div class="col-12 my-3">
            <div class="confirmation-box">
                <div class="icon-check">
                    <span>&#10003;</span>
                </div>
                <p>شكرا لك. لقد تم استلام طلبك.</p>
            </div>
        </div>
    </div>
    <div class="row px-4">
        <div class="col-3 p-1  border-start border-end text-center">
            <p class="text-muted m-0">رقم الطلب:</p>
            <p class="fw-bold m-0">{{$order->number}}</p>
        </div>
        <div class="col-3 p-1  border-start border-end text-center">
            <p class="text-muted m-0">التاريخ:</p>
            <p class="fw-bold m-0">{{$order->created_at->translatedFormat('M d ,Y')}}</p>
        </div>
        <div class="col-3 p-1  border-start border-end text-center">
            <p class="text-muted m-0">المجموع:</p>
            <p class="fw-bold m-0" dir="ltr"> {{number_format($order->total,2,',',' ')}} <span>د.م</span></p>
        </div>
        <div class="col-3 p-1  border-start border-end text-center">
            <p class="text-muted m-0">طريقة الدفع:</p>
            <p class="fw-bold m-0"> {{$order->payment_method}} </p>
        </div>
    </div>
    <div class="card mt-5 border-0 shadow-sm">
        <div class="card-body px-5">
            <h4 class="">تفاصيل الطلب</h4>
            <hr class="border" >

            <div class="row bg-primary p-2 text-white rounded my-3">
                <div class="col-3">المنتج</div>
                <div class="col-3">الكمية</div>
                <div class="col-3">الثمن</div>
                <div class="col-3">المجموع</div>
            </div>
            @foreach($order->lines as $line)
                <div class="row py-2">
                    <div class="col-3"><a @if($line->article_id) href="" @endif>{{$line->article_title}}</a></div>
                    <div class="col-3">{{$line->quantity}}</div>
                    <div class="col-3 text-end" dir="ltr">{{number_format($line->price,2,',',' ')}} <span>د.م</span>
                    </div>
                    <div class="col-3 text-end" dir="ltr">{{number_format($line->price * $line->quantity,2,',',' ')}}
                        <span>د.م</span></div>
                </div>
            @endforeach
           <div class="border p-3 mt-4 rounded col-6">
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
    <div class="row pt-4">
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm border-0 d-100">
                <div class="card-body">
                    <h4 class="">عنوان وصول الفواتير</h4>
                    <hr class="border" >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <p class="">الاسم الأول:</p>
                                <p class="text-muted fw-bold">{{$order->billing_address->first_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <p class="">الاسم الأخير:</p>
                                <p class="text-muted fw-bold">{{$order->billing_address->last_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <p class="">المدينة:</p>
                                <p class="text-muted fw-bold">@lang('city.'.$order->billing_address->city)</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <p class="">الهاتف:</p>
                                <p class="text-muted fw-bold">{{$order->billing_address->phone_number}}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <p class="">العنوان:</p>
                                <p class="text-muted fw-bold">{{$order->billing_address->address}}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <p class="">البريد الالكتروني:</p>
                                <p class="text-muted fw-bold">{{$order->billing_address->email}}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm border-0 w-100">
                <div class="card-body">
                    <h4 class="">عنوان الشحن</h4>
                    <hr class="border" >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <p class="">الاسم الأول:</p>
                                <p class="text-muted fw-bold">{{$order->shipping_address->first_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <p class="">الاسم الأخير:</p>
                                <p class="text-muted fw-bold">{{$order->shipping_address->last_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <p class="">المدينة:</p>
                                <p class="text-muted fw-bold">@lang('city.'.$order->shipping_address->city)</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <p class="">العنوان:</p>
                                <p class="text-muted fw-bold">{{$order->shipping_address->address}}</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
