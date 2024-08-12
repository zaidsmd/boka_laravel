@extends('layouts.main')
@section('document-title','المتجر')
@section('page')
    <div class="row py-4">
        @foreach($articles as $article)
            <div class="col-xl-3 col-lg-4 col-sm-6 py-2">
                <div class="card border-0 shadow-sm overflow-hidden product-card" data-id="{{$article->id}}">
                    <div class="card-img w-100 position-relative">
                        <div class="add-to-cart-card">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <img src="https://picsum.photos/id/{{$article->id+100}}/300/300" class="img-fluid w-100" alt="">
                    </div>
                    <div class="card-body text-center">
                        {{--                            <a href="" class="d-block fs-6 text-decoration-none text-muted">{{$article->categories?->first->name}}</a>--}}
                        <a href="" class="fw-medium text-decoration-none text-muted">{{$article->title}}</a>
                        @if($article->sale_price)
                            <p class="fs-5 fw-bold text-primary"><span
                                    class="mx-2 text-decoration-line-through text-orange-400 fw-normal"> د.م {{number_format($article->price,2,',',' ')}} </span>
                                د.م {{number_format($article->sale_price,2,',',' ')}}</p>
                        @else
                            <p class="fs-5 fw-bold text-primary">
                                د.م {{number_format($article->price,2,',',' ')}}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
