@extends('back_office.admin_layouts.main')
@section('document-title','Users')
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
                        <h2>قائمة المستخدمين
                        </h2>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <a href="{{ route('utilisateurs.ajouter') }}" class="btn btn-primary mr-3">
                           <i class="mdi mdi-plus"></i>  إضافة مستخدم
                        </a>

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
                <div class="table-responsive">
                    <table style="width: 100%;" id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th > {{__('lang.product.id')}}</th>
                            <th > الاسم الشخصي</th>
                            <th > الاسم العائلي </th>
                            <th > البريد الإلكتروني</th>
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

    @include('layouts.partials.js.__datatable_js')
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

        const __dataTable_columns =  [
            // {data: 'selectable_td', orderable: false, searchable: false, class: 'check_sell'},
            { "data": "id" },
            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "email" },
            {data: 'actions', name: 'actions', orderable: false,},
        ];
        const __dataTable_ajax_link = "{{ route('utilisateurs.liste') }}";
        const __dataTable_id = "#datatable";
        const __dataTable_filter_inputs_id = {
            famille_id: '#cat-select',
            designation: '#title-input',
            reference: '#reference-input',
        }
        const __dataTable_filter_trigger_button_id ='#search-btn';

    </script>
    <script src="{{asset('js/dataTable_init.js')}}"></script>

@endpush
