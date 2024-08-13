@extends('layouts.main')
@section('document-title','المتجر')
@section('page')
    <div class="row py-4">
        <div class="col-md-3 d-md-block d-none pt-3">
            <div class="input-group">
                <button class="input-append btn btn-primary text-white" ><i class="fa fa-search"></i></button>
                <input type="text" class="form-control" placeholder="بحث...">
            </div>
            <div class="form-group py-3">
                <label for="max" class="form-label text-orange-400" >السعر</label>
                <div class="input-group">
                    <input type="number" id="max" class="form-control" placeholder="الى">
                    <input type="number" id="min" min="0" class="form-control" placeholder="من">
                </div>
            </div>
            <div class=" py-3">
                <p  class="form-label text-orange-400" >التصنيفات</p>
                @foreach($categories as $category)
                    <div class="form-check-inline w-100 py-1">
                        <input type="checkbox" name="categories[]" value="{{$category->slug}}" id="{{$category->slug}}" class="form-check-input">
                        <label for="{{$category->slug}}" class="form-check-label">{{$category->name}} <span class="text-muted" >({{$category->articles()->count()}})</span></label>
                    </div>
                @endforeach
            </div>
            <div class=" py-3">
                <p  class="form-label text-orange-400" >عروضات خاصة</p>
                <div class="form-check-inline w-100 py-1">
                    <input type="checkbox" name="sale" value="1" id="sale" class="form-check-input">
                    <label for="sale" class="form-check-label">تخفيض <span class="text-muted" >({{$articles_sale_count}})</span></label>
                </div>
            </div>

        </div>
        <div class="col-md-9 col-12 row m-0 shop-cards-container">
            <h1 class="text-primary mb-4">المتجر</h1>

            {{--            @foreach($articles as $article)--}}
            {{--               @include('partials.article-card',compact('article'))--}}
            {{--            @endforeach--}}
            {{--                {{$articles->links()}}--}}

        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/shop.js'])
@endpush
