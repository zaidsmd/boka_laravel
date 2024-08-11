@extends('layouts.main')
@section('page')
    <h2 class="text-primary mb-4" >سلة المشتريات</h2>
   <div class="cart-container">
       @include('partials.cart-table')
   </div>
@endsection
