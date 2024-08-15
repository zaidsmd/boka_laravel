@extends('admin_layouts.main')
@section('document-title','tags')
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
                        <h2> قائمة الوسوم
                        </h2>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <button class="btn btn-primary" data-bs-target="#add-marque-modal"
                                data-bs-toggle="modal"><i class="mdi mdi-plus"></i>  إضافة وسم
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
                            <th style="width: 10%;"> {{__('lang.product.id')}}</th>
                            <th > الاسم  </th>
                            <th > النوع  </th>
                            <th > {{__('lang.product.actions')}}</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="add-marque-modal" tabindex="-1" aria-labelledby="add-marque-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title align-self-center" id="add-marque-modal-title">  إضافة وسم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('tags.sauvegarder') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label required" for="name">الإسم</label>
                                <input type="text" required class="form-control" id="name" name="name">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label required" for="type">النوع</label>
                                <input type="text" required class="form-control" id="type" name="type">
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


    <div class="modal fade" id="edit-categorie-modal" tabindex="-1" aria-labelledby="edit-categorie-modal-title" aria-hidden="true" style="position:fixed;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditChargeLabel">تحديث وسم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('lang.buttons.close') }}"></button>
                </div>
                <div class="modal-body center-block">
                    <form id="form_edit_charge" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 form-group">
                            <input class="form-control" type="text" id="name" required name="name" >
                        </div>
                        <div class="mb-3 form-group">
                            <input class="form-control" type="text" id="type" required name="type">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('lang.buttons.edit') }}</button>
                    </form>
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

        $('#categories_table').on('click', '.edit-categorie', function(event) {
            event.preventDefault();
            var categorieId = $(this).data('id-categorie');
            $.ajax({
                url: "{{ route('tags.modifier', ['id' => ':id']) }}".replace(':id', categorieId),
                method: 'GET',
                success: function(response) {
                    // Populate the modal with category data
                    $('#edit-name').val(response.name);
                    $('#edit-id').val(response.id);
                    $('#edit-type').val(response.type);
                    // Set the form action to include the category id
                    $('#edit-categorie-form').attr('action', "{{ route('tags.mettre_a_jour', ['id' => ':id']) }}".replace(':id', response.id));
                    $('#edit-categorie-modal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error fetching category data:', xhr);
                }
            });
        });

        function openEditModal(chargeId, chargeDescription, type) {
            var modal = $('#edit-categorie-modal');
            modal.find('#name').val(chargeDescription);
            modal.find('#type').val(type);

            var formActionUrl = '{{ route("tags.mettre_a_jour", ["id" => ":id"]) }}'.replace(':id', chargeId);
            modal.find('form').attr('action', formActionUrl);

            // Ensure the form uses the PUT method
            modal.find('form').append('<input type="hidden" name="_method" value="PUT">');

            // Show the modal
            modal.modal('show');
        }
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
            { "data": "name" },
            { "data": "type"  },
            {data: 'actions', name: 'actions', orderable: false,},
        ];
        const __dataTable_ajax_link = "{{ route('tags.liste') }}";
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
