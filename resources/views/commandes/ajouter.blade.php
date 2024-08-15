@extends('admin_layouts.main')
@section('document-title','Orders')
@push('css')
    <link rel="stylesheet" href="{{asset('libs/select2/css/select2.min.css')}}">
    <link href="{{asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('libs/daterangepicker/css/daterangepicker.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('libs/dropify/css/dropify.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/spectrum-colorpicker2/spectrum.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/filepond/plugins/css/filepond-plugin-image-preview.css')}}">
    <link rel="stylesheet" href="{{asset('libs/filepond/css/filepond.css')}}">
@endpush
@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="commandes-form" enctype="multipart/form-data" action="{{route('commandes.sauvegarder')}}"
                          method="post"   autocomplete="off">
                        @csrf
                        <!-- #####--Card Title--##### -->
                        <div class="card-title">
                            <div id="__fixed" class="d-flex switch-filter justify-content-between align-items-center">
                                <div>
                                    <a href="{{route('commandes.liste')}}"><i class="fa fa-arrow-left"></i></a>
                                    <h5 class="m-0 float-end ms-3">
                                        <i class="mdi me-2 text-success mdi-account-group"></i>
                                        إضافة طلب
                                    </h5>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-soft-info"><i class="fa fa-save"></i> حفظ</button>
                                </div>

                            </div>
                            <hr class="border">
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <label for="first_name" class="form-label required">الاسم الشخصي</label>
                                <input id="first_name" type="text" class="form-control @error('first_name')  is-invalid @enderror "
                                       name="first_name" value="{{old('first_name')}}">
                                @error('first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="last_name" class="form-label required">الاسم العائلي</label>
                                <input id="last_name" type="text" class="form-control @error('last_name')  is-invalid @enderror "
                                       name="last_name" value="{{old('last_name')}}">
                                @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="email" class="form-label required">البريد الإلكتروني</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror "
                                       name="email" value="{{old('email')}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="phone_number" class="form-label required"> الهاتف</label>
                                <input type="tel" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror "
                                       name="phone_number" value="{{old('phone_number')}}">
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <label for="city " class="form-label required"> المدينة</label>
                                <div class="input-group">
                                    <input type="text" id="city"
                                           class="form-control @error('city') is-invalid @enderror "
                                           name="city" value="{{old('city')}}">
                                    @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-3">
                                <label for="address " class="form-label required"> العنوان</label>
                                <div class="input-group">
                                    <input type="text" id="address"
                                           class="form-control @error('address') is-invalid @enderror "
                                           name="address" value="{{old('address')}}">

                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-3">
                                <label for="payment_method " class="form-label required"> طرق الدفع</label>
                                <div class="input-group">
                                    <select name="payment_method" id="payment_method"
                                    class="select2 form-control @error('payment_method') is-invalid @enderror " >
                                        <option value="نقدا عند الاستلام"> تحويل مصرفي مباشر</option>
                                        <option value="تحويل مصرفي">الدفع نقدًا عند الاستلام</option>
                                    </select>
                                    @error('payment_method')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div data-simplebar="init" class="table-responsive col-12 mt-3">
                                <table class="table rounded overflow-hidden table-hover table-striped" id="table">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-white">رقم المنتج</th>
                                        <th class="text-white">المنتج</th>
                                        <th class="text-white">الكمية</th>
                                        <th class="text-white">السعر</th>
                                        <th class="text-white">السعر الإجمالي</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="productTableBody">
                                    <!-- Rows will be added dynamically here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end">
                                <button type="button" id="addRowBtn" class="btn btn-sm btn-soft-success add_row">
                                    <i class="fa fa-plus"></i> Ajouter une ligne
                                </button>
                            </div>

                        </div>
                        <div class="col-12 mt-3 row justify-content-between p-2">
                            <div class="col-6"></div>
                            <div class="col-6 row m-0 bg-primary p-3 rounded text-white" style="max-width: 500px">
                                <h5 class="col-4 fw-normal">Total HT</h5>
                                <h5 class="col-8 text-end fw-normal" id="total-ht-text">0.00 MAD</h5>
                                <h5 class="col-4 fw-normal">Total Réduction</h5>
                                <h5 class="col-8 text-end fw-normal" id="total-reduction-text">0.00 MAD</h5>
                                <h5 class="col-4 fw-normal">Total TVA</h5>
                                <h5 class="col-8 text-end fw-normal" id="total-tva-text">0.00 MAD</h5>
                                <h5 class="col-4 mb-0 fw-normal">Total TTC</h5>
                                <h2 class="col-8 mb-0 text-end" id="total-ttc-text">0.00 MAD</h2>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script src="{{asset('libs/spectrum-colorpicker2/spectrum.min.js')}}" ></script>
    <script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>

    <script src="{{asset('libs/daterangepicker/js/daterangepicker.js')}}"></script>
    <script src="{{asset('libs/dropify/js/dropify.min.js')}}"></script>

    <script src="{{asset('libs/filepond/plugins/js/filepond-plugin-image-preview.js')}}"></script>
    <script src="{{asset('libs/filepond/js/filepond.js')}}"></script>
    <script src="{{asset('libs/filepond/plugins/js/filepond-plugin-image-validate-size.js')}}"></script>
    <script src="{{asset('libs/filepond/plugins/js/filepond-plugin-file-validate-type.js')}}"></script>


    <script>
        $("#categorie").select2({
            placeholder: "...",
            ajax: {
                url: "{{ route('categories.select') }}",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: data,
                    };
                },
                cache: false,
            },
            minimumInputLength: 1,
        });
    </script>
    <script>
        $('#payment_method').select2({
            placeholder: "...",
            minimumResultsForSearch: -1

        })
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            function initializeSelect2() {
                $('.product-select').select2({
                    placeholder: 'Select a product',
                    allowClear: true,
                    width: '100%'
                });
            }

            // Function to calculate total for each row
            function calculateTotal(row) {
                var quantity = parseFloat(row.find('.quantity').val()) || 0;
                var price = parseFloat(row.find('.price').val()) || 0;
                var total = quantity * price;
                row.find('.total').text(total.toFixed(2) + ' MAD');
                calculateGrandTotal();
            }

            // Function to calculate the grand total
            function calculateGrandTotal() {
                var grandTotal = 0;
                $('#productTableBody .total').each(function() {
                    grandTotal += parseFloat($(this).text()) || 0;
                });
                $('#total-ttc-text').text(grandTotal.toFixed(2) + ' MAD');
            }

            // Add a new row
            $('#addRowBtn').click(function() {
                var newRow = `
            <tr>
                <td>
                    <select class="form-control product-select" name="product[]">
                        <option value="">اختر المنتج</option>
                        <option value="1">Produit 1</option>
                        <option value="2">Produit 2</option>
                        <option value="3">Produit 3</option>
                        <!-- Add more options as needed -->
                    </select>
                </td>
                <td><input type="text" class="form-control" name="product_name[]" readonly></td>
                <td><input type="number" class="form-control quantity" name="quantity[]" min="1" value="1"></td>
                <td><input type="number" class="form-control price" name="price[]" min="0.00" step="0.01" value="0.00"></td>
                <td><span class="total">0.00 MAD</span></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button></td>
            </tr>`;
                $('#productTableBody').append(newRow);
                initializeSelect2();
            });

            // Remove a row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateGrandTotal();
            });

            // Calculate total on quantity or price change
            $(document).on('input', '.quantity, .price', function() {
                var row = $(this).closest('tr');
                calculateTotal(row);
            });

            // Populate product name on product select change
            $(document).on('change', '.product-select', function() {
                var selectedProduct = $(this).find('option:selected').text();
                $(this).closest('tr').find('input[name="product_name[]"]').val(selectedProduct);
            });
        });

    </script>



@endpush
