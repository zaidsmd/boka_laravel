@extends('back_office.admin_layouts.main')
@section('document-title','Orders')
@push('css')
    @include('layouts.partials.css.__datatable_css')
    <link rel="stylesheet" href="{{asset('libs/select2/css/select2.min.css')}}">
    <link href="{{asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('libs/daterangepicker/css/daterangepicker.min.css')}}" rel="stylesheet">
    <style>
        .last-col {
            width: 1%;
            white-space: nowrap;
        }
    </style>
@endpush

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- #####--Card Title--##### -->
                    <div class="card-title">
                        <div id="__fixed" class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{route('commandes.liste')}}"><i class="fa fa-arrow-right"></i></a>
                                <h5 class="m-0 float-end ms-3" style="margin-top: .1rem!important"><i
                                        class="mdi mdi-chart-bell-curve-cumulative me-2 text-success"></i>
                                     تفاصيل الطلب
                                    <span
                                        class="text-muted opacity-75 font-size-12 text-nowrap text-truncate"></span>
                                </h5>
                            </div>
                            <div class="pull-right">

                                <button id="status-btn"
                                        data-href="{{route('commandes.status_modal',$o_order->id)}}"
                                        class="btn btn-primary mx-1"><i class="fa fa-edit"></i> تحديث الحالة
                                </button>


                            </div>
                        </div>
                        <hr class="border">
                    </div>


                    <div class="row py-3 px-1 mx-0 my-3 rounded">
                        <div class="col-lg-2 col-xl-2 col-sm-6 col-md-4   d-flex align-items-center">
                            <div class="rounded bg-soft-info  p-2 d-flex align-items-center justify-content-center"
                                 style="width: 49px">
                                <i class="fa fa-id-card fa-2x"></i>
                            </div>
                            <div class="ms-3 ">
                                <span class="font-weight-bolder font-size-sm">رقم الطلب</span>
                                <p class="mb-0 h5 text-black">{{$o_order->number}}</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-sm-6 col-md-4  mt-lg-0 mt-3 d-flex align-items-center">
                            <div class="rounded bg-soft-success  p-2 d-flex align-items-center justify-content-center"
                                 style="width: 49px">
                                <i class="fa fa-star fa-2x"></i>
                            </div>
                            <div class="ms-3 ">
                                <span class="font-weight-bolder font-size-sm">الحالة</span>
                                <p class="mb-0 h5 text-black text-capitalize">
                                    @if($o_order->status == 'processing')
                                        قيد المعالجة
                                    @elseif($o_order->status == 'on-hold')
                                        في الانتظار
                                    @else
                                        {{$o_order->status}}
                                    @endif
                                </p>
                            </div>
                        </div>


                        <div class="col-lg-2 col-xl-2 col-sm-6 col-md-4  mt-3 d-flex align-items-md-start">
                            <div
                                class="rounded bg-warning text-white  p-2 d-flex align-items-center justify-content-center"
                                style="width: 49px">
                                <i class="fa fa-coins fa-2x"></i>
                            </div>
                            <div class="ms-3 ">
                                <span class="font-weight-bolder font-size-sm">الثمن الإجمالي </span>
                                <p class="mb-0 h5 text-black text-capitalize">{{$o_order->total}}</p>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-sm-6 col-md-4  mt-3 d-flex align-items-md-start">
                            <div
                                class="rounded bg-danger text-white  p-2 d-flex align-items-center justify-content-center"
                                style="width: 49px">
                                <i class="fa fa-money-bill fa-2x"></i>
                            </div>
                            <div class="ms-3 ">
                                <span class="font-weight-bolder font-size-sm">رسوم الشحن </span>
                                <p class="mb-0 h5 text-black text-capitalize">{{$o_order->shipping_fee}}</p>
                            </div>
                        </div>


                        <div class="col-lg-2 col-xl-2 col-sm-6 col-md-4  mt-3 d-flex align-items-md-start">
                            <div
                                class="rounded bg-info text-white  p-2 d-flex align-items-center justify-content-center"
                                style="width: 49px">
                                <i class="fa fa-cash-register fa-2x"></i>
                            </div>
                            <div class="ms-3 ">
                                <span class="font-weight-bolder font-size-sm"> طريقة الدفع </span>
                                <p class="mb-0 h5 text-black text-capitalize">{{$o_order->payment_method}}</p>
                            </div>
                        </div>
{{--                        <div class="col-lg-2 col-xl-2 col-sm-6 col-md-4  mt-3 d-flex align-items-md-start">--}}
{{--                            <div--}}
{{--                                class="rounded bg-success text-white  p-2 d-flex align-items-center justify-content-center"--}}
{{--                                style="width: 49px">--}}
{{--                                <i class="fa fa-mail-bulk fa-2x"></i>--}}
{{--                            </div>--}}
{{--                            <div class="ms-3 ">--}}
{{--                                <span class="font-weight-bolder font-size-sm">البريد الإلكتروني </span>--}}
{{--                                <p class="mb-0 h5 text-black text-capitalize">{{$o_order->billing_email}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}


                    </div>

                </div>
            </div>
        </div>
    </div>


       <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-title">
                        <div id="__fixed" class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="m-0 float-end ms-3" style="margin-top: .1rem!important"><i
                                        class="mdi mdi-chart-bell-curve-cumulative me-2 text-success"></i>
                                    تفاصيل المنتجات
                                    <span
                                        class="text-muted opacity-75 font-size-12 text-nowrap text-truncate"></span>
                                </h5>
                            </div>
                            <div class="pull-right">
                            </div>
                        </div>
                        <hr class="border">
                    </div>


                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active " id="articles" role="tabpanel">
                            <div data-simplebar="init" class="table-responsive col-12 mt-3">
                                <table class="table rounded overflow-hidden table-hover table-striped"
                                       id="table">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-white" style="width: 1%; white-space: nowrap"> رقم المنتج </th>
                                        <th class="text-white w-50">المنتج</th>
                                        <th class="text-white px-4">الكمية</th>
                                        <th class="text-white px-4">السعر</th>
                                        <th class="text-white px-4" >
                                            السعر الإجمالي
                                        </th>
                                    </tr>

                                    </thead>
                                    <!-- The tbody tag will be populated by JavaScript -->
                                    <tbody id="productTableBody">
                                    @forelse($o_order->lines->sortby('position') as $ligne)
                                        <tr>
                                            <td>
                                                {{$ligne->article_id}}
                                            </td>
                                            <td>
                                                {{$ligne->article_title}}
                                            </td>
                                            <td>
                                                {{$ligne->quantity}}
                                            </td>
                                            <td>
                                                {{$ligne->price}}
                                            </td>
                                            <td>
                                                {{ number_format($ligne->price * $ligne->quantity, 2) }}
                                            </td>

                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 mt-3 row justify-content-between ">
                                <div class="col-6"></div>
                                <div class="col-6 row  bg-primary p-3 rounded text-white" style="max-width: 500px">
                                    <h5 class="col-4 fw-normal">المجموع الفرعي</h5>
                                    <h5 class="col-8 text-end fw-normal"
                                        id="total-ht-text">    {{$totalPrice}}      د.م   </h5>
                                    <h5 class="col-4 fw-normal">الشحن</h5>
                                    <h5 class="col-8 text-end fw-normal"
                                        id="total-reduction-text">
                                       {{$o_order->shipping_fee}}    د.م </h5>
                                    <h5 class="col-4 fw-normal">المجموع </h5>
                                    <h5 class="col-8 text-end fw-normal " id="total-tva-text">

                                        <strong></strong>
                                        {{$o_order->total}}     د.م </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- #####--Card Title--##### -->
                    <div class="card-title">
                        <div id="__fixed" class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="m-0 float-end ms-3" style="margin-top: .1rem!important"><i
                                        class="mdi mdi-chart-bell-curve-cumulative me-2 text-success"></i>
                                    عنوان وصول الفواتير
                                    <span
                                        class="text-muted opacity-75 font-size-12 text-nowrap text-truncate"></span>
                                </h5>
                            </div>
                            <div class="pull-right">
                            </div>
                        </div>
                        <hr class="border">
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active " id="articles" role="tabpanel">
                            <div data-simplebar="init" class="table-responsive col-12 mt-3">
                                <table class="table rounded overflow-hidden table-hover table-striped"
                                       id="table">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-white" > الاسم الشخصي </th>
                                        <th class="text-white ">
                                            الاسم العائلي</th>
                                        <th class="text-white px-4">المدينة</th>
                                        <th class="text-white px-4">الهاتف</th>
                                        <th class="text-white px-4" >
                                            العنوان
                                        </th> <th class="text-white px-4" >
                                            البريد الالكتروني
                                        </th>
                                    </tr>

                                    </thead>
                                    <!-- The tbody tag will be populated by JavaScript -->
                                    <tbody id="productTableBody">

                                        <tr>
                                            <td>
                                                {{$o_order->first_name}}
                                            </td>
                                            <td>
                                                {{$o_order->last_name}}
                                            </td>
                                            <td>
                                                {{$o_order->city}}
                                            </td>
                                            <td>
                                                {{$o_order->phone_number}}
                                            </td>
                                            <td>
                                                {{$o_order->address}}
                                            </td>
                                            <td>
                                                {{$o_order->billing_email}}
                                            </td>


                                        </tr>

                                    </tbody>
                                </table>
                            </div>


                             </div>
                         </div>
                    </div>
            </div>
        </div>
    </div>
        @if($o_order->type == 1)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- #####--Card Title--##### -->
                    <div class="card-title">
                        <div id="__fixed" class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="m-0 float-end ms-3" style="margin-top: .1rem!important"><i
                                        class="mdi mdi-chart-bell-curve-cumulative me-2 text-success"></i>
                                    عنوان الشحن
                                    <span
                                        class="text-muted opacity-75 font-size-12 text-nowrap text-truncate"></span>
                                </h5>
                            </div>
                            <div class="pull-right">


                            </div>
                        </div>
                        <hr class="border">
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active " id="articles" role="tabpanel">
                            <div data-simplebar="init" class="table-responsive col-12 mt-3">
                                <table class="table rounded overflow-hidden table-hover table-striped"
                                       id="table">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-white" > الاسم الشخصي </th>
                                        <th class="text-white ">
                                            الاسم العائلي</th>
                                        <th class="text-white px-4">المدينة</th>
                                        <th class="text-white px-4" >
                                            العنوان

                                    </tr>

                                    </thead>
                                    <!-- The tbody tag will be populated by JavaScript -->
                                    <tbody id="productTableBody">

                                    <tr>
                                        <td>
                                            {{$o_order->shipping_address->first_name}}
                                        </td>
                                        <td>
                                            {{$o_order->shipping_address->last_name}}
                                        </td>
                                        <td>
                                            {{$o_order->shipping_address->city}}
                                        </td>
                                        <td>
                                            {{$o_order->shipping_address->address}}
                                        </td>



                                    </tr>

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="modal fade" id="conversion-modal" tabindex="-1" aria-labelledby="conversion-modal-title"
         aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>

    {{--    Afficher {{$o_order->number}}--}}

@endsection
@push('scripts')

    <script src="{{asset('libs/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
    <script src="{{asset('libs/daterangepicker/js/daterangepicker.js')}}"></script>

    <script>
        $(document).ready(function(){

            var successMessage = '{{ session('success') }}';
            if (successMessage) {
                Swal.fire({
                    title: '{{ __("lang.succes") }}',
                    text: successMessage,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });

        var conversion_modal_process = !1;
        $('#status-btn').on('click', function () {
            if (!conversion_modal_process) {
                conversion_modal_process = !0;
                $.ajax({
                    url: $(this).data('href'),
                    method: 'GET',
                    success: function (response) {
                        conversion_modal_process = !1;
                        $('#conversion-modal .modal-content').html(response);
                        $('#conversion-modal').modal('show')
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        conversion_modal_process = !1;
                    }
                })
            }
        });
    </script>

@endpush
