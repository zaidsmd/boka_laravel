@extends('admin_layouts.main')

@section('css')
    .btn-container {
    display: flex;
    float: right;
    gap: 5px;
    }

@endsection
@section('section')
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h2>{{__('lang.category.list')}}</h2>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
{{--                        <a href="{{ route('categories.ajouter') }}" class="btn btn-primary mr-3">--}}
{{--                            Ajouter une catégorie--}}
{{--                        </a>--}}

                        <button class="btn btn-primary" data-bs-target="#add-marque-modal"
                                data-bs-toggle="modal"><i class="mdi mdi-plus"></i> {{__('lang.category.add')}}
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
                <div class="table-responsive">
                    <table style="width: 100%;" id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>الإسم </th>
                            <th style="width: 10%">الإجراءات</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="add-marque-modal" tabindex="-1" aria-labelledby="add-marque-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title align-self-center" id="add-marque-modal-title">{{__('lang.category.add')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('categories.sauvegarder') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label required" for="name">الإسم</label>
                                <input type="text" required class="form-control" id="name" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                        <button class="btn btn-primary">إضافة</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-categorie-modal" tabindex="-1" aria-labelledby="edit-categorie-modal-title" aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@push('scripts')
    @include('layouts.partials.js.__datatable_js')
    <script src="{{asset('libs/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
    <script src="{{asset('libs/daterangepicker/js/daterangepicker.js')}}"></script>
    <script>

        var processing = 0;
        $(document).on('click', '.__datatable-edit-modal', function () {
            if (processing === 0) {
                processing = 1;
                let html = $(this).html();
                $(this).attr('disabled', '').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
                let url = $(this).data('url');
                let target = '#' + $(this).data('target');
                $.ajax({
                    url: url, method: 'GET', success: response => {
                        processing = 0;
                        $(this).removeAttr('disabled').html(html)
                        $(target).find('.modal-content').html(response);
                        $(target).modal('show');
                    }, error: xhr => {
                        processing = 0;
                        $(this).removeAttr('disabled').html(html)
                        if(xhr.status !== undefined) {
                            if (xhr.status === 403) {
                                toastr.warning("Vous n'avez pas l'autorisation nécessaire pour effectuer cette action");
                                return
                            }
                        }
                        toastr.error('Un erreur est produit')
                    }
                })
            }

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
            { "data": "name" },
            {data: 'actions', name: 'actions', orderable: false,},
        ];
        const __dataTable_ajax_link = "{{ route('categories.liste') }}";
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
