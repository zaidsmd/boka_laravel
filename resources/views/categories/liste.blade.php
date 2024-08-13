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
                    <table style="width: 100%;" id="categories_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="display:none;">id </th>
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


    <div class="modal fade" id="edit-categorie-modal" tabindex="-1" aria-labelledby="edit-categorie-modal-title" aria-hidden="true" style="position:fixed;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditChargeLabel">تحديث الفئة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('lang.buttons.close') }}"></button>
                </div>
                <div class="modal-body center-block">
                    <form id="form_edit_charge" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 form-group">
                            <input class="form-control" type="text" id="name" required name="name" placeholder="{{ __('lang.edit_charge_description') }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('lang.buttons.edit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#categories_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('categories.liste') }}",
                "columns": [
                    { "data": "name" },
                    {"data" : "actions"}
                ],
                "language": {
                    "sProcessing": "{{ __('datatable.processing') }}",
                    "sLengthMenu": "{{ __('datatable.empty_table') }}",
                    "sZeroRecords": "{{ __('datatable.zero_records') }}",
                    "sEmptyTable": "{{ __('datatable.empty_table') }}",
                    "sInfo": "{{ __('datatable.info') }}",
                    "sInfoEmpty": "{{ __('datatable.info_empty') }}",
                    "sInfoFiltered": "{{ __('datatable.info_filtered') }}",
                    "sInfoPostFix": "{{ __('datatable.datatable_info_postfix') }}",
                    "sSearch": "{{ __('datatable.search') }}",
                    "sUrl": "{{ __('datatable.datatable_url') }}",
                    "sInfoThousands": "{{ __('datatable.info_thousands') }}",
                    "sLoadingRecords": "{{ __('datatable.loading_records') }}",
                    "oPaginate": {
                        "sFirst": "{{ __('datatable.datatable_first') }}",
                        "sLast": "{{ __('datatable.datatable_last') }}",
                        "sNext": "{{ __('datatable.datatable_next') }}",
                        "sPrevious": "{{ __('datatable.datatable_previous') }}"
                    },
                    "oAria": {
                        "sSortAscending": "{{ __('datatable.datatable_sort_ascending') }}",
                        "sSortDescending": "{{ __('datatable.datatable_sort_descending') }}"
                    }
                }


            });
        });


        function openEditModal(chargeId, chargeDescription) {
            var modal = $('#edit-categorie-modal');
            modal.find('#name').val(chargeDescription);

            var formActionUrl = '{{ route("categories.mettre_a_jour", ["id" => ":id"]) }}'.replace(':id', chargeId);
            modal.find('form').attr('action', formActionUrl);

            // Ensure the form uses the PUT method
            modal.find('form').append('<input type="hidden" name="_method" value="PUT">');

            // Show the modal
            modal.modal('show');
        }

        function redirectToCreatePage() {
            window.location.href = "{{ route('categories.ajouter') }}";
        }




        $('#categories_table').on('click', '.delete-categorie', function() {
            var categorieId = $(this).data('id');
            Swal.fire({
                title: "{{ __('lang.confirm_delete_title') }}",
                text: "{{ __('lang.confirm_delete_text') }}",
                icon: "{{ __('lang.confirm_delete_icon') }}",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "{{ __('lang.confirm_delete_button') }}",
                cancelButtonText: "{{ __('lang.cancel_button') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    $('#delete-form-' + categorieId).submit();
                }
            });
        });



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
        {{--// Handle edit button click--}}
        {{--$('#categories_table').on('click', '.edit-categorie', function(event) {--}}
        {{--    event.preventDefault();--}}
        {{--    var categorieId = $(this).data('id-categorie');--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('categories.modifier', ['id' => ':id']) }}".replace(':id', categorieId),--}}
        {{--        method: 'GET',--}}
        {{--        success: function(response) {--}}
        {{--            // Populate the modal with category data--}}
        {{--            $('#edit-name').val(response.name);--}}
        {{--            $('#edit-id').val(response.id);--}}
        {{--            // Set the form action to include the category id--}}
        {{--            $('#edit-categorie-form').attr('action', "{{ route('categories.mettre_a_jour', ['id' => ':id']) }}".replace(':id', response.id));--}}
        {{--            $('#edit-categorie-modal').modal('show');--}}
        {{--        },--}}
        {{--        error: function(xhr) {--}}
        {{--            console.error('Error fetching category data:', xhr);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
    </script>
@endpush
