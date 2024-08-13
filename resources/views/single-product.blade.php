@extends('layouts.main')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/magnific-popup/magnific-popup.css')}}">
@endpush
@section('page')
    <div class="d-flex flex-column align-items-md-start flex-md-row mt-4">
        <div id="carousel-single" class="carousel slide">
            <div class="carousel-inner zoom-gallery bg-body rounded  p-2 ">
                @foreach($article->getMedia('images') as $key => $media)
                    <div href="{{$media->original_url}}" class="carousel-item @if($key == 0) active @endif" data-source="{{$media->original_url}}" >
                        <img src="{{$media->original_url}}" alt="Thumbnail 1" class="img-fluid"/>
                    </div>
                @endforeach
            </div>
            <div class="carousel-indicators">
                @foreach($article->getMedia('images') as $key => $media)
                    <button type="button" data-bs-target="#carousel-single" data-bs-slide-to="{{$key}}"
                            class="active thumbnail" aria-current="true" aria-label="Slide 1">
                        <img src="{{$media->original_url}}" alt="Thumbnail 1" class="img-fluid"/>
                    </button>

                @endforeach
            </div>
        </div>
        <div class=" w-100 p-3 px-5">
            <h1  class="text-primary mb-4" >{{$article->title}}</h1>
            <div class="row align-items-center justify-content-between gap-2">
                <div class="price w-auto gap-3 text-nowrap d-inline-flex" dir="ltr">
                    @if($article->sale_price)
                        <h5 class="text-primary m-0" >{{number_format($article->sale_price ,2,',',' ')}} د.م</h5>
                    @endif
                    <h5 class="@if($article->sale_price) text-orange-300 text-decoration-line-through  @else text-primary @endif text-nowrap  m-0" >{{number_format($article->price ,2,',',' ')}} د.م</h5>
                </div>
                <div class="quantity w-auto d-inline-flex align-items-center gap-3  justify-content-end">
                    <input type="number" class="form-control" min="1" value="1" style="max-width: 70px">
                    <button class="btn btn-primary text-white text-nowrap add-to-cart-card-single" data-id="{{$article->id}}" >إضافة إلى السلة</button>
                </div>
            </div>
            <p class="pt-4" >{!! $article->description !!}</p>
        </div>
    </div>
    <h2 class="text-primary" >كتب لها علاقة</h2>
    <hr class="border" >
    <div class="row">
        @foreach($relateds as $article)
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
        @endforeach
    </div>

@endsection
@push('scripts')
    <script src="{{asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.zoom-gallery').magnificPopup({
                delegate: 'div',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',

                // If you enable allowHTMLInTemplate -
                // make sure your HTML attributes are sanitized if they can be created by a non-admin user
                allowHTMLInTemplate: false,


                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300, // don't foget to change the duration also in CSS
                    opener: function(element) {
                        return element.find('img');
                    }
                }

            });
        });
    </script>
@endpush
