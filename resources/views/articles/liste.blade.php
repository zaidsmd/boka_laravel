@extends('admin_layouts.main')

@section('css')
    .btn-container {
    display: flex;
    float: right;
    gap: 5px;
    }

@endsection
@section('section')

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Liste des articles</h2>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <a href="{{ route('articles.ajouter') }}" class="btn btn-primary mr-3">
                            Ajouter un article
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
                    <table style="width: 100%;" id="articles_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="display:none;">id </th>
                            <th>Titre </th>
                            <th>Slug </th>
                            <th>Prix d'achat</th>
                            <th>Prix de vente </th>
                            <th>Description courte</th>
                            <th>Description </th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#articles_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('articles.liste') }}",
                "columns": [
                    { "data": "title" },
                    { "data": "slug" },
                    { "data": "price" },
                    { "data": "sale_price" },
                    { "data": "short_description" },
                    { "data": "description" },
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



        function redirectToCreatePage() {
            window.location.href = "{{ route('articles.liste') }}";
        }




        $('#articles_table').on('click', '.delete-article', function() {
            var articleId = $(this).data('id'); // Extract the achat ID from the data-id attribute
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
                    $('#delete-form-' + articleId).submit();
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

        $(document).ready(function() {
            var processing = false;

            $('.edit-achat').on('click', function(event) {
                event.preventDefault(); // Prevent default form submission behavior
                if (processing) {
                    return;
                }
                processing = true;
                var achatId = $(this).data('id-achat');
                $.ajax({
                    url: '/achats/' + achatId,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#quantity_edit').val(response.quantity);
                        $('#price_edit').val(response.price);

                    },
                    complete: function() {
                        processing = false;
                    }
                });
            });
        });
    </script>
@endpush
