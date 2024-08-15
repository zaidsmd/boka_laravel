@extends('layouts.main')
@section('document-title',$category->name)
@section('page')
    <div class="row py-4 ">
        <div class="col-12 ">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="text-primary">{{$category->name}}</h1>
            </div>
            <input type="hidden" value="{{$category->slug}}" id="_cat">
            <div class="row m-0 shop-cards-container align-content-start"></div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/category.js'])
@endpush
