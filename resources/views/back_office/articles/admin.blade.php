@extends('back_office.admin_layouts.main')
@section('document-title','Articles')
@push('styles')
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
                            <h5 class="m-0"><i class="fa  fas fa-boxes me-2 text-success"></i> Articles
                            </h5>
                            <div class="pull-right">
                                <a href="{{route('articles.ajouter')}}" class="btn btn-soft-success"><i
                                            class="mdi mdi-plus"></i> Ajouter</a>
                                <button class="filter-btn btn btn-soft-info"><i class="fa fa-filter"></i> Filtrer
                                </button>
                            </div>
                        </div>
                        <hr class="border">
                    </div>
                    <div class="card-title switch-filter d-none col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Filtres</h5>
                        </div>
                        <hr class="border">
                    </div>
                    <!-- #####--Filters--##### -->
                    <div class="switch-filter row d-none mt-2 mb-4">
                        <div class="col-sm-3 col-12 mb-3">
                            <label class="form-label" for="cat-select">Famille</label>
                            <select class="select2 form-control mb-3 custom-select" name="famille_id" id="cat-select">
                            </select>
                        </div>
                        <div class="col-sm-3 col-12 mb-3">
                            <label class="form-label" for="title-input">Désignation</label>
                            <input type="text" class="form-control" id="title-input"
                                   name="title">
                        </div>
                        <div class="col-sm-3 col-12 mb-3">
                            <label class="form-label" for="sku-input">Référence</label>
                            <input type="text" class="form-control" id="reference-input"
                                   name="sku">
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button id="search-btn" class="btn btn-primary"><i class="mdi mdi-magnify"></i> Rechercher
                            </button>
                        </div>
                    </div>
                    <!-- #####--DataTable--##### -->
                    <div class="row">
                        <div class="card-title switch-filter d-none col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="m-0">Listes des Articles</h5>
                            </div>
                            <hr class="border">
                        </div>
                        <div class="col-12">
                            <div>
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px">
                                            <input type="checkbox" class="form-check-input" id="select-all-row">
                                        </th>
                                        <th>Référence</th>
                                        <th>Désignation</th>
                                        <th>Famille</th>
                                        <th>Unité</th>
                                        <th>Quantité</th>
                                        <th>Prix de vente</th>
                                        <th style="width: 100px">Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
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

        const __dataTable_columns = [
            {data: 'selectable_td', orderable: false, searchable: false, class: 'check_sell'},
            {data: 'reference', name: 'reference'},
            {data: 'designation', name: 'designation'},
            {data: 'famille_id', name: 'famille.nom'},
            {data: 'unite_id', name: 'unite_id'},
            {data: 'quantite', name: 'quantite'},
            {data: 'prix_vente', name: 'prix_vente'},
            {data: 'actions', name: 'actions', orderable: false,},
        ];
        const __dataTable_ajax_link = "{{ route('articles.admin') }}";
        const __dataTable_id = "#datatable";
        const __dataTable_filter_inputs_id = {
            famille_id: '#cat-select',
            designation: '#title-input',
            reference: '#reference-input',
        }
        const __dataTable_filter_trigger_button_id = '#search-btn';

    </script>
    <script src="{{asset('js/dataTable_init.js')}}"></script>
@endpush
