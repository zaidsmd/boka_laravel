@extends('layouts.main')
@section('document-title','المتجر')
@section('page')
    <div class="row py-4 ">
        <div class="col-md-3 d-md-block d-none pt-3 filters-container">
            <div class="input-group">
                <button class="input-append btn btn-primary text-white search"><i class="fa fa-search"></i></button>
                <input type="text" id="search-input" class="form-control" placeholder="بحث..." value="{{$search ?? null}}">
            </div>
            <div class="form-group py-3">
                <label for="max" class="form-label text-orange-400">السعر</label>
                <div class="input-group">
                    <input type="number" id="max" class="form-control filter" placeholder="الى">
                    <input type="number" id="min" min="0" class="form-control filter" placeholder="من">
                </div>
            </div>
            <div class="input-form py-3">
                <label for="sort-desktop" class="form-label text-primary">الترتيب</label>
                <select name="sort" id="sort-desktop" class="form-select filter">
                    <option  value="">ترتيب افتراضي</option>
                    <option @selected($sort === 'date')  value="date">الأقدم أولاً</option>
                    <option @selected($sort === 'date-desc')  value="date-desc">الأحدث أولاًً</option>
                    <option @selected($sort === 'price') value="price">الأقل سعراً أولاً</option>
                    <option @selected($sort === 'price-desc') value="price-desc">الأكثر سعراً أولاً</option>
                </select>
            </div>
            <div class=" py-3">
                <p class="form-label text-orange-400">الفئة العمرية</p>
                @foreach($orderedTags as $tag)
                    <div class="form-check-inline w-100 py-1">
                        <input @checked($selected_tag === $tag->slug) type="checkbox" name="tags" value="{{ $tag->id }}" id="tag-{{ $tag->slug }}" class="form-check-input filter">
                        <label for="tag-{{ $tag->slug }}" class="form-check-label">{{ $tag->name }}
                            <span class="text-muted">({{ $tag->articles()->where('status', 'published')->count() }})</span>
                        </label>
                    </div>
                @endforeach

                @foreach($newTags as $tag)
                    <div class="form-check-inline w-100 py-1">
                        <input @checked($selected_tag === $tag->slug) type="checkbox" name="tags" value="{{ $tag->id }}" id="tag-{{ $tag->slug }}" class="form-check-input filter">
                        <label for="tag-{{ $tag->slug }}" class="form-check-label">{{ $tag->name }}
                            <span class="text-muted">({{ $tag->articles()->where('status', 'published')->count() }})</span>
                        </label>
                    </div>
                @endforeach
            </div>
            <div class=" py-3">
                <p class="form-label text-orange-400">التصنيفات</p>
                @foreach($categories as $category)
                    <div class="form-check-inline w-100 py-1">
                        <input @checked($selected_category === $category->slug) type="checkbox" name="categories" value="{{$category->id}}" id="cat-{{$category->slug}}"
                               class="form-check-input filter">
                        <label for="cat-{{$category->id}}" class="form-check-label">{{$category->name}} <span
                                class="text-muted">({{$category->articles()->where('status','published')->count()}})</span></label>
                    </div>
                @endforeach
            </div>
            <div class=" py-3">
                <p class="form-label text-orange-400">عروضات خاصة</p>
                <div class="form-check-inline w-100 py-1">
                    <input @checked($sale) type="checkbox" name="sale" value="1" id="sale" class="form-check-input filter">
                    <label for="sale" class="form-check-label">تخفيض </label>
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
                البحث</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body large">
            <div id="canvas-replace"></div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/shop.js'])
@endpush
