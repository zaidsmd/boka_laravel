@extends('layouts.main')
@section('document-title',$article->title)
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/magnific-popup/magnific-popup.css')}}">
@endpush
@section('page')
    <div class="d-flex flex-column align-items-md-start flex-md-row mt-4">
        <div id="carousel-single" class="carousel slide">
            <div class="carousel-inner zoom-gallery bg-body rounded  p-2 ">
                @foreach($article->getMedia('images') as $key => $media)
                    <div href="{{$media->original_url}}" class="carousel-item @if($key == 0) active @endif"
                         data-source="{{$media->original_url}}">
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
            <h1 class="text-primary mb-4">{{$article->title}}</h1>
            <div class="row align-items-center justify-content-between gap-2">
                <div class="price w-auto gap-3 text-nowrap d-inline-flex" dir="ltr">
                    @if($article->sale_price)
                        <h5 class="text-primary m-0">{{number_format($article->sale_price ,2,',',' ')}} د.م</h5>
                    @endif
                    <h5 class="@if($article->sale_price) text-orange-300 text-decoration-line-through  @else text-primary @endif text-nowrap  m-0">{{number_format($article->price ,2,',',' ')}}
                        د.م</h5>
                </div>
                @if($article->quantite)
                    <div class="quantity w-auto d-inline-flex align-items-center gap-3  justify-content-end">
                        <input type="number" class="form-control" min="1" max="{{$article->quantite}}" value="1" style="max-width: 70px">
                        <button class="btn btn-primary text-white text-nowrap add-to-cart-card-single"
                                data-id="{{$article->id}}">إضافة إلى السلة
                        </button>
                        <div class="errors text-danger"></div>
                    </div>
                @else
                    <h6 class="text-danger d-inline" >هذا المنتج غير متوفر</h6>
                @endif

            </div>
            <p class="pt-4">{!! $article->description !!}</p>
        </div>
    </div>
    <h2 class="text-primary">كتب لها علاقة</h2>
    <hr class="border">
    <div class="row">
        @foreach($relateds as $article)
            @include('partials.article-card')
        @endforeach
    </div>

@endsection
@push('scripts')
    <script src="{{asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script>
        $(document).ready(function () {
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
                    opener: function (element) {
                        return element.find('img');
                    }
                }

            });
        });
    </script>
@endpush
