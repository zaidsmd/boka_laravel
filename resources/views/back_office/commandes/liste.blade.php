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

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h2>قائمة الطلبات
                        </h2>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
{{--                        <a href="{{ route('commandes.ajouter') }}" class="btn btn-primary mr-3">--}}
{{--                            <i class="mdi mdi-plus"></i>--}}
{{--                            إضافة طلب--}}
{{--                        </a>--}}
                        <button class="filter-btn btn btn-soft-info"><i class="fa fa-filter"></i>  فلتر
                        </button>

                    </div>
                </div>
                <br>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="switch-filter row px-3 d-none mt-2 mb-4">
                    <div class="card-title col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0">الفلاتر</h5>
                        </div>
                        <hr class="border">
                    </div>

                    <div class="col-sm-3 col-12 mb-3">
                        <label class="form-label" for="numero">رقم الطلب </label>
                        <input type="text" class="form-control" id="numero"
                               name="numero">
                    </div>
                    <div class="col-sm-3 col-12 mb-3">
                        <label class="form-label" for="nom">الاسم الشخصي أو العائلي</label>
                        <input type="text" class="form-control" id="nom"
                               name="nom">
                    </div>

                    <div class="col-sm-3 col-12 mb-3">
                        <label class="form-label" for="city">	المدينة</label>
                        <input type="text" class="form-control" id="city"
                               name="city">
                    </div>
                    <div class=" col-lg-3  col-12 ">
                        <label for="payment_method " class="form-label required"> طرق الدفع</label>
                        <div class="input-group">

                            <select name="payment_method" id="payment_method"
                                    class="select2 form-control @error('payment_method') is-invalid @enderror " >
                                <option value="0">--</option>
                                <option value="نقدا عند الاستلام">الدفع نقدًا عند الاستلام</option>
                                <option value="تحويل مصرفي"> تحويل مصرفي مباشر</option>
                            </select>
                            @error('payment_method')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button id="search-btn" class="btn btn-primary"><i class="mdi mdi-magnify"></i> بحث
                        </button>
                    </div>
                </div>                    <!-- #####--DataTable--##### -->

                <div class="table-responsive">
                    <table style="width: 100%;" id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th > رقم الطلب</th>
                            <th > التاريخ </th>
                            <th > الاسم الشخصي	 </th>
                            <th > الاسم العائلي	 </th>
                            <th >	المدينة	 </th>
                            <th > الثمن الإجمالي </th>
                            <th > رسوم الشحن</th>
                            <th > البريد الإلكتروني</th>
                            <th > طريقة الدفع</th>
                            <th > الحالة </th>

                            <th > {{__('lang.product.actions')}}</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>

    @include('layouts.partials.js.__datatable_js')
    <script src="{{asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
    <script src="{{asset('libs/daterangepicker/js/daterangepicker.js')}}"></script>

    <script>

        $('.filter-btn').click(e => {
            $('.switch-filter').toggleClass('d-none')
        })
        $('#payment_method').select2({
            placeholder: "...",
            minimumResultsForSearch: -1,
            width: '100%'


        })
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

        const __dataTable_columns =  [
            // {data: 'selectable_td', orderable: false, searchable: false, class: 'check_sell'},
            { "data": "number" },
            {"data" : 'created_at'},

            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "city" },
            { "data": "total" },
            { "data": "shipping_fee" },
            { "data": "billing_email" },
            { "data": "payment_method" },
            {
                "data": "status",
                "render": function(data, type, row) {
                    let statusClass = '';
                    let statusLabel = '';

                    switch (data) {
                        case 'معلق': // STATUS_PENDING
                            statusClass = 'bg-warning text-dark'; // Bootstrap class for warning
                            statusLabel = 'معلق';
                            break;
                        case 'قيد المعالجة': // STATUS_PROCESSING
                            statusClass = 'bg-info text-white'; // Bootstrap class for info
                            statusLabel = 'قيد المعالجة';
                            break;
                        case 'مُرسل': // STATUS_SHIPPED
                            statusClass = 'bg-primary text-white'; // Bootstrap class for primary
                            statusLabel = 'مُرسل';
                            break;
                        case 'تم التوصيل': // STATUS_DELIVERED
                            statusClass = 'bg-success text-white'; // Bootstrap class for success
                            statusLabel = 'تم التوصيل';
                            break;
                        case 'ملغى': // STATUS_CANCELED
                            statusClass = 'bg-danger text-white'; // Bootstrap class for danger
                            statusLabel = 'ملغى';
                            break;
                        case 'في الانتظار': // STATUS_ONHOLD
                            statusClass = 'bg-secondary text-white'; // Bootstrap class for secondary
                            statusLabel = 'في الانتظار';
                            break;
                        default:
                            statusClass = 'bg-dark text-white'; // Default class for unknown status
                            statusLabel = data;
                            break;
                    }

                    return '<span class="badge ' + statusClass + '">' + statusLabel + '</span>';
                }
            }     ,
            {data: 'actions', name: 'actions', orderable: false,},
        ];
        const __dataTable_ajax_link = "{{ route('commandes.liste') }}";
        const __dataTable_id = "#datatable";
        const __dataTable_filter_inputs_id = {
            numero: '#numero',
            nom: '#nom',
            city: '#city',
            payment_method: '#payment_method',
        }
        const __dataTable_filter_trigger_button_id ='#search-btn';

    </script>
    <script src="{{asset('js/dataTable_init.js')}}"></script>

@endpush
