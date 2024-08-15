@extends('layouts.main')
@section('document-title','المتجر')
@section('page')
    <div class="row py-4 ">
        <div class="col-md-3 d-md-block d-none pt-3">
            <div class="input-group">
                <button class="input-append btn btn-primary text-white search"><i class="fa fa-search"></i></button>
                <input type="text" id="search-input" class="form-control" placeholder="بحث...">
            </div>
            <div class="form-group py-3">
                <label for="max" class="form-label text-orange-400">السعر</label>
                <div class="input-group">
                    <input type="number" id="max" class="form-control filter" placeholder="الى">
                    <input type="number" id="min" min="0" class="form-control filter" placeholder="من">
                </div>
            </div>
            <div class=" py-3">
                <p class="form-label text-orange-400">التصنيفات</p>
                @foreach($categories as $category)
                    <div class="form-check-inline w-100 py-1">
                        <input type="checkbox" name="categories" value="{{$category->id}}" id="{{$category->id}}"
                               class="form-check-input filter">
                        <label for="{{$category->id}}" class="form-check-label">{{$category->name}} <span
                                class="text-muted">({{$category->articles()->count()}})</span></label>
                    </div>
                @endforeach
            </div>
            <div class=" py-3">
                <p class="form-label text-orange-400">عروضات خاصة</p>
                <div class="form-check-inline w-100 py-1">
                    <input type="checkbox" name="sale" value="1" id="sale" class="form-check-input filter">
                    <label for="sale" class="form-check-label">تخفيض <span
                            class="text-muted">({{$articles_sale_count}})</span></label>
                </div>
            </div>

        </div>

        <div class="col-md-9 col-12 ">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="text-primary">المتجر</h1>
                <button class="btn btn-primary d-block d-md-none text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-canvas" aria-controls="filters-canvas"><i class="fa fa-filter"></i></button>
            </div>

            <div class="row m-0 shop-cards-container align-content-start"></div>
            {{--            @foreach($articles as $article)--}}
            {{--               @include('partials.article-card',compact('article'))--}}
            {{--            @endforeach--}}
            {{--                {{$articles->links()}}--}}
            <div class="py-3 text-center ">
                <nav class="pagination-container" dir="ltr" ></nav>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="filters-canvas" aria-labelledby="filters-canvasLabel">
        <div class="offcanvas-header d-flex justify-content-between">
            <h5 class="offcanvas-title w-100" id="cart-canvasLabel">
                البحت</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body large">
            <div class="input-group">
                <button class="input-append btn btn-primary text-white search"><i class="fa fa-search"></i></button>
                <input type="text" id="search-input" class="form-control" placeholder="بحث...">
            </div>
            <div class="form-group py-3">
                <label for="max" class="form-label text-orange-400">السعر</label>
                <div class="input-group">
                    <input type="number" id="max" class="form-control filter" placeholder="الى">
                    <input type="number" id="min" min="0" class="form-control filter" placeholder="من">
                </div>
            </div>
            <div class=" py-3">
                <p class="form-label text-orange-400">التصنيفات</p>
                @foreach($categories as $category)
                    <div class="form-check-inline w-100 py-1">
                        <input type="checkbox" name="categories" value="{{$category->id}}" id="{{$category->id}}"
                               class="form-check-input filter">
                        <label for="{{$category->id}}" class="form-check-label">{{$category->name}} <span
                                class="text-muted">({{$category->articles()->count()}})</span></label>
                    </div>
                @endforeach
            </div>
            <div class=" py-3">
                <p class="form-label text-orange-400">عروضات خاصة</p>
                <div class="form-check-inline w-100 py-1">
                    <input type="checkbox" name="sale" value="1" id="sale" class="form-check-input filter">
                    <label for="sale" class="form-check-label">تخفيض <span
                            class="text-muted">({{$articles_sale_count}})</span></label>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/shop.js'])
@endpush
