@extends('back_office.admin_layouts.main')

@section('document-title','Home Articles')

@push('css')
    <style>
        .product-table, .sale-table {
            width: 100%;
            border-collapse: collapse;
        }
        .product-table th, .sale-table th,
        .product-table td, .sale-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .product-table th, .sale-table th {
            background-color: #f4f4f4;
            text-align: right;
        }
        .product-table img, .sale-table img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .product-table .move-up, .sale-table .move-up,
        .product-table .move-down, .sale-table .move-down {
            cursor: pointer;
        }
        .product-table .move-up.disabled, .sale-table .move-up.disabled,
        .product-table .move-down.disabled, .sale-table .move-down.disabled {
            color: #ccc;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="articles-form" action="{{ route('home_articles.sauvegarder') }}" enctype="multipart/form-data" method="post" autocomplete="off">
                        <div class="card-title">
                            <div id="__fixed" class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="m-0 float-end ms-3">
                                        <i class="fa fas fa-boxes me-2 text-success"></i>
                                        إعدادات  الصفحة الرئيسية
                                    </h5>
                                </div>
                                <div class="pull-right">
                                    <button id="save-btn" class="btn btn-soft-info" type="submit">
                                        <i class="fa fa-save"></i> {{ __('lang.articles.save') }}
                                    </button>
                                </div>
                            </div>
                            <hr class="border">
                        </div>
                        @csrf
                        <input type="hidden" name="product_order_data" id="product-order-data">
                        <input type="hidden" name="sale_order_data" id="sale-order-data">

                        <div class="row">
                            <div class="col-sm-6 row mx-0 col-12 align-content-start">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">أحدث الإصدارات   </h5>
                                    <hr class="border border-success">
                                </div>

                                <div class="col-12 col-lg-12 mb-3 ">
                                    <label class="form-label" for="latest"> منتجات </label>
                                    <div class="input-group">
                                        <select
                                            class="select2 form-control mb-3 custom-select {{$errors->has('latest')? 'is-invalid' : ''}}"
                                            name="latest[]"
                                            id="latest" multiple>
                                            @foreach($selectedProducts as $selected)
                                                <option value="{{ $selected->article_id }}"
                                                        selected >
                                                    {{ $selected->text }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @if($errors->has('latest'))
                                                {{ $errors->first('latest') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Table to display selected products -->
                                <div class="col-12 mt-4">
                                    <h5 class="text-muted">المنتجات المختارة (أحدث الإصدارات)</h5>
                                    <table class="product-table">
                                        <thead>
                                        <tr>
                                            <th>الترتيب</th>
                                            <th> المعرف</th>

                                            <th>اسم المنتج</th>
                                            <th style="width: 20%">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody id="product-table-body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-sm-6 row mx-0 col-12 align-content-start">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">أسعار مخفظة</h5>
                                    <hr class="border border-success">
                                </div>
                                <div class="col-12 col-lg-12 mb-3 ">
                                    <label class="form-label" for="sale"> منتجات </label>
                                    <div class="input-group">
                                        <select
                                            class="select2 form-control mb-3 custom-select {{$errors->has('sale')? 'is-invalid' : ''}}"
                                            name="sale[]"
                                            id="sale" multiple>
                                            @foreach($selectedSaleProducts as $selected)
                                                <option value="{{ $selected->article_id }}"
                                                        selected >
                                                    {{ $selected->text }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @if($errors->has('sale'))
                                                {{ $errors->first('sale') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Table to display selected sale products -->
                                <div class="col-12 mt-4">
                                    <h5 class="text-muted">المنتجات المختارة (أسعار مخفضة)</h5>
                                    <table class="sale-table" >
                                        <thead>
                                        <tr>
                                            <th>الترتيب</th>
                                            <th> المعرف</th>
                                            <th>اسم المنتج</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                        </thead>
                                        <tbody id="sale-table-body">

                                        </tbody>
                                    </table>
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
    </script>
    <script>
        $("#latest").select2({
            placeholder: "البحث عن منتج",
            language: 'ar',
            ajax: {
                url: "{{ route('articles.select_latest') }}",
                dataType: "json",
                data: function (params) {
                    return { term: params.term };
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: false,
            },
            minimumInputLength: 3,

        });

        $("#sale").select2({
            placeholder: "البحث عن منتج",
            language: 'ar',
            ajax: {
                url: "{{ route('articles.select_sale') }}",
                dataType: "json",
                data: function (params) {
                    return { term: params.term };
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: false,
            },
            minimumInputLength: 3,

        });
    </script>
    <script>
        $(document).ready(function () {
            // Preload latest products from the database into the table
            const latestProducts = @json($latestProducts);
            const saleProducts = @json($saleProducts);

            latestProducts.forEach(function (product) {
                addProductToTable(product.article.id, product.article.title );
            });
            saleProducts.forEach(function (product) {
                addProductToSaleTable(product.article.id, product.article.title);
            });

            function addProductToSaleTable(id, name) {
                const saleTableBody = $("#sale-table-body");

                // Check if product is already in the table
                if ($(`#sale-row-${id}`).length > 0) {
                    return; // Prevent duplicates
                }

                const rowCount = saleTableBody.children().length + 1;

                const rowHtml = `
                <tr id="sale-row-${id}" data-id="${id}">
                    <td>${rowCount}</td>
                    <td>${id}</td>
                    <td>${name}</td>
                    <td>
                        <button type="button" class="btn btn-soft-warning btn-sm sale-move-up "><i class="fas fa-chevron-up"></i></button>
                        <button type="button" class="btn btn-soft-info btn-sm sale-move-down "><i class="fas fa-chevron-down"></i></button>
                        <button type="button" class="btn btn-soft-danger btn-sm sale-remove-product"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            `;

                saleTableBody.append(rowHtml);
                updatesaleRowOrder(); // Update row numbers
                initializesaleRowActions();
            }

            // Same JavaScript logic to add products to the table dynamically
            function addProductToTable(id, name) {
                const productTableBody = $("#product-table-body");

                // Check if product is already in the table
                if ($(`#product-row-${id}`).length > 0) {
                    return; // Prevent duplicates
                }

                const rowCount = productTableBody.children().length + 1;

                const rowHtml = `
                <tr id="product-row-${id}" data-id="${id}">
                    <td>${rowCount}</td>
                    <td>${id}</td>
                    <td>${name}</td>
                    <td>
                        <button type="button" class="btn btn-soft-warning btn-sm move-up "><i class="fas fa-chevron-up"></i></button>
                        <button type="button" class="btn btn-soft-info btn-sm move-down "><i class="fas fa-chevron-down"></i></button>
                        <button type="button" class="btn btn-soft-danger btn-sm remove-product"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            `;

                productTableBody.append(rowHtml);
                updateRowOrder(); // Update row numbers
                initializeRowActions();


            }

            function initializeRowActions() {
                $('.move-up').off('click').on('click', function () {
                    const row = $(this).closest('tr');
                    const prevRow = row.prev();

                    if (prevRow.length) {
                        row.insertBefore(prevRow);
                        updateRowOrder();
                    }
                });

                $('.move-down').off('click').on('click', function () {
                    const row = $(this).closest('tr');
                    const nextRow = row.next();

                    if (nextRow.length) {
                        row.insertAfter(nextRow);
                        updateRowOrder();
                    }
                });

                $('.remove-product').off('click').on('click', function () {
                    const row = $(this).closest('tr');
                    const id = row.data('id');
                    removeProductFromSelect(id); // Remove from select2
                    $(this).closest('tr').remove();
                    updateRowOrder();
                });
            }

            function initializesaleRowActions() {
                $('.sale-move-up').off('click').on('click', function () {
                    const row = $(this).closest('tr');
                    const prevRow = row.prev();

                    if (prevRow.length) {
                        row.insertBefore(prevRow);
                        updatesaleRowOrder();
                    }
                });

                $('.sale-move-down').off('click').on('click', function () {
                    const row = $(this).closest('tr');
                    const nextRow = row.next();

                    if (nextRow.length) {
                        row.insertAfter(nextRow);
                        updatesaleRowOrder();
                    }
                });

                $('.sale-remove-product').off('click').on('click', function () {
                    const row = $(this).closest('tr');
                    const id = row.data('id');
                    removeProductFromSaleSelect(id); // Remove from select2
                    $(this).closest('tr').remove();
                    updatesaleRowOrder();
                });
            }

            function updateRowOrder() {
                const rows = $('#product-table-body tr');
                rows.each(function(index, row) {
                    const $row = $(row);
                    $row.find('td:first').text(index + 1); // Update order number

                    // Enable/Disable buttons
                    $row.find('.move-up').prop('disabled', index === 0);
                    $row.find('.move-down').prop('disabled', index === rows.length - 1);
                });
            }

            function updatesaleRowOrder() {
                const rows = $('#sale-table-body tr');
                rows.each(function(index, row) {
                    const $row = $(row);
                    $row.find('td:first').text(index + 1); // Update order number
                    // Enable/Disable buttons
                    $row.find('.move-up').prop('disabled', index === 0);
                    $row.find('.move-down').prop('disabled', index === rows.length - 1);
                });
            }

            // Handle product selection from select2 (same as before)
            $('#latest').on('select2:select', function (e) {
                const selectedProduct = e.params.data;
                addProductToTable(selectedProduct.id, selectedProduct.text);
            });
            $('#latest').on('select2:unselect', function (e) {
                const deselectedProduct = e.params.data;
                removeProductFromTable(deselectedProduct.id);
            });

            $('#sale').on('select2:select', function (e) {
                const selectedProduct = e.params.data;
                addProductToSaleTable(selectedProduct.id, selectedProduct.text);
            });
            $('#sale').on('select2:unselect', function (e) {
                const deselectedProduct = e.params.data;
                removeProductFromSaleTable(deselectedProduct.id);
            });
            function removeProductFromTable(id) {
                $(`#product-row-${id}`).remove();
                updateRowOrder();
            }

            function removeProductFromSaleTable(id) {
                $(`#sale-row-${id}`).remove();
                updatesaleRowOrder();
            }
            function updateHiddenField() {
                const tableData = [];
                const saleData = [];
                $('#product-table-body tr').each(function () {
                    const row = $(this);
                    const id = row.data('id');
                    const displayOrder = row.find('td').first().text();
                    tableData.push({ id, displayOrder });
                });
                $('#product-order-data').val(JSON.stringify(tableData));
                $('#sale-table-body tr').each(function () {
                    const row = $(this);
                    const id = row.data('id');
                    const displayOrder = row.find('td').first().text();
                    saleData.push({ id, displayOrder });
                });
                $('#sale-order-data').val(JSON.stringify(saleData));
            }
            $('#articles-form').on('submit', function (e) {
                updateHiddenField();
            });

            function removeProductFromSelect(id) {
                // Remove the option from the select2 dropdown
                const select2 = $('#latest').data('select2');
                if (select2) {
                    // Remove the option from the dropdown list
                    const option = select2.$dropdown.find(`option[value="${id}"]`);
                    if (option.length) {
                        option.remove();
                    }
                    // Remove the option from the select element
                    $('#latest').find(`option[value="${id}"]`).remove();
                    // Update the select2 component to reflect changes
                    $('#latest').val($('#latest').val().filter(value => value !== id)).trigger('change');
                }
            }

            function removeProductFromSaleSelect(id) {
                // Remove the option from the select2 dropdown
                const select2 = $('#sale').data('select2');
                if (select2) {
                    // Remove the option from the dropdown list
                    const option = select2.$dropdown.find(`option[value="${id}"]`);
                    if (option.length) {
                        option.remove();
                    }
                    // Remove the option from the select element
                    $('#sale').find(`option[value="${id}"]`).remove();
                    // Update the select2 component to reflect changes
                    $('#sale').val($('#sale').val().filter(value => value !== id)).trigger('change');
                }
            }



        });
    </script>


@endpush
