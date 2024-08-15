@extends('layouts.main')
@section('document-title','المتجر')
@section('page')
    <div class="row py-4 ">

        <div class=" col-12 ">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="text-primary">التخفيضات</h1>
            </div>

            <div class="row m-0 shop-cards-container align-content-start"></div>
            <div class="py-3 text-center ">
                <nav class="pagination-container" dir="ltr" ></nav>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @vite(['resources/js/sale.js'])
@endpush
