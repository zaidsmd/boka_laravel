@extends('back_office.admin_layouts.main')
@section('document-title','Articles')
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
                        <h2>قائمة المنتجات</h2>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <a href="{{ route('articles.ajouter') }}" class="btn btn-primary mr-3">
                            <i class="mdi mdi-plus"></i> {{__('lang.product.add_product')}}
                        </a>
                        <button class="btn filter-btn btn-soft-warning mx-2"  >@lang('datatable.filter') <i class="fa fa-filter"></i></button>
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
                            <h5 class="m-0">البحث</h5>
                        </div>
                        <hr class="border">
                    </div>

                    <div class="col-sm-3 col-12 mb-3">
                        <label class="form-label" for="title-input">@lang('lang.product.title')</label>
                        <input type="text" class="form-control" id="title-input"
                               name="sku">
                    </div>
                    <div class="col-sm-3 col-12 mb-3">
                        <label class="form-label" for="price-input">@lang('lang.product.sale_price')</label>
                        <input type="number" class="form-control" id="price-input">
                    </div>

                    <div class="col-sm-3 col-12 mb-3">
                        <label class="form-label" for="categories-select">الفئات</label>
                        <select multiple class="select2 form-control mb-3 custom-select" id="categories-select">
                            @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->text}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 col-12 mb-3">
                        <label class="form-label" for="tags-select">الوسوم</label>
                        <select multiple class="select2 form-control mb-3 custom-select" id="tags-select">
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->text}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button id="search-btn" class="btn btn-primary"><i class="mdi mdi-magnify"></i> @lang('lang.search')
                        </button>
                    </div>
                </div>                    <!-- #####--DataTable--##### -->

                <div class="table-responsive">
                    <table style="width: 100%;" id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th > {{__('lang.product.id')}}</th>
                            <th > {{__('lang.product.title')}}</th>
                            <th > {{__('lang.product.sale_price')}}</th>
                            <th > {{__('lang.articles.reduit_price')}}</th>
                            <th > {{__('lang.product.quantity')}}</th>
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
            { "data": "title" },
            { "data": "price" },
            { "data": "sale_price" },
            { "data": "quantite" },
            {data: 'actions', name: 'actions', orderable: false,},
        ];
        const __dataTable_ajax_link = "{{ route('articles.liste') }}";
        const __dataTable_id = "#datatable";
        const __dataTable_filter_inputs_id = {
            categories: '#categories-select',
            title: '#title-input',
            price: '#price-input',
            tags: '#tags-select',
        }
        const __dataTable_filter_trigger_button_id ='#search-btn';
        $('#tags-select, #categories-select').select2(
            {
                width:'100%'
            }
        )
    </script>
    <script src="{{asset('js/dataTable_init.js')}}"></script>

@endpush
