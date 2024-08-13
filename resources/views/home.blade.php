@extends('layouts.main')
@section('document-title','الصفحة الرئيسية')
@section('page')
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('images/Carousel-1.jpg')}}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/Carousel-2.jpg')}}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <section class="pt-4">
        <div class="section-divider">
            <span class="text-primary fw-bold">اختر الكتب حسب العمر</span>
        </div>
        <div class="section-divider">
            <span class="text-primary fw-bold">أحدث الإصدارات</span>
        </div>
        <div class="row py-4">
            @foreach($latest as $article)
               @include('partials.article-card',[compact('article')])
            @endforeach
        </div>
        <div class="section-divider">
            <span class="text-primary fw-bold">أسعار مخفضة</span>
        </div>
        <div class="row py-4">
            @foreach($sales as $article)
                @include('partials.article-card',[compact('article')])
            @endforeach
        </div>
    </section>
@endsection
