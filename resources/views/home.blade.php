@extends('layouts.main')
@section('document-title','الصفحة الرئيسية')

@push('styles')
    <style>
        .carousel{
            direction: ltr;
        }
    </style>
@endpush
@section('page')
    <div class="message-area"></div>

    <div id="carouselExampleIndicators" class="carousel slide direction-right" data-bs-ride="carousel" >
        <div class="carousel-indicators">
            @foreach($sliders as $index => $slider)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($sliders as $index => $slider)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }} ">
                    <a href="{{ $slider->url }}">
                        <img src="{{ $slider->getUrl() }}" class="d-block w-100" alt="Slide {{ $index + 1 }}">
                    </a>
                </div>
            @endforeach
        </div>


        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <section class="pt-4">
        <div class="section-divider">
            <span class="text-primary fw-bold">اختر الكتب حسب العمر</span>
        </div>
        <div class="row py-5 justify-content-center">
            <a href="{{route('shop.tags','0-3-سنوات')}}" class="d-flex justify-content-center align-items-center home-age-cat"><img src="{{asset('images/1-1.png')}}" class="img-fluid" alt=""></a>
            <a href="{{route('shop.tags','3-6-سنوات')}}" class=" d-flex justify-content-center align-items-center home-age-cat"><img src="{{asset('images/2-1.png')}}"  class="img-fluid"alt=""></a>
            <a  href="{{route('shop.tags','6-9-سنوات')}}" class=" d-flex justify-content-center align-items-center home-age-cat"><img src="{{asset('images/3-1.png')}}" class="img-fluid" alt=""></a>
            <a href="{{route('shop.tags','9-12-سنوات')}}" class=" d-flex justify-content-center align-items-center home-age-cat"><img src="{{asset('images/4-1.png')}}" class="img-fluid" alt=""></a>
            <a href="{{route('shop.tags','12-15-سنوات')}}" class=" d-flex justify-content-center align-items-center home-age-cat"><img src="{{asset('images/5-1.png')}}" class="img-fluid" alt=""></a>
            <a href="{{route('shop.tags','16-سنوات')}}" class=" d-flex justify-content-center align-items-center home-age-cat"><img src="{{asset('images/6-1.png')}}" class="img-fluid" alt=""></a>
            <a href="{{route('shop.tags','الوالدية')}}" class=" d-flex justify-content-center align-items-center home-age-cat"><img src="{{asset('images/7-1.png')}}" class="img-fluid" alt=""></a>
        </div>
        <div class="section-divider">
            <span class="text-primary fw-bold">أحدث الإصدارات</span>
        </div>
        <div class="row py-4">
            @foreach($latest as $article)
                @if($article->status == 'published')
                    @include('partials.article-card', ['article' => $article])
                @endif
            @endforeach
        </div>

        <div class="section-divider">
            <span class="text-primary fw-bold">أسعار مخفضة</span>
        </div>
        <div class="row py-4">
            @foreach($sales as $article)
                @if($article->status == 'published')
                    @include('partials.article-card', ['article' => $article])
                @endif
            @endforeach
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var carouselElement = document.querySelector('#carouselExampleIndicators');
            var transitionTime = ({{$o_slider->transition_time}} || 5000); // Default to 5000ms if null
            var autoplay = {{$o_slider->autoplay}}; // Get autoplay value

            var carouselOptions = {
                interval: transitionTime,
                ride: autoplay === 0 ? 'carousel' : false
            };

            var carousel = new bootstrap.Carousel(carouselElement, carouselOptions);
        });
    </script>

@endpush


