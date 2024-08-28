@extends('layouts.main')
@section('document-title','سلة المشتريات')
@section('page')
    <h2 class="text-primary mb-4" >سلة المشتريات</h2>
   <div class="cart-container">
       @include('partials.cart-table',['cities' =>$cities ,'cart'=> $cart ,'selected_city_price' => $selected_city_price])
   </div>
@endsection
