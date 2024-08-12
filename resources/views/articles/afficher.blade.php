@extends('admin_layouts.main')
@section('document-title','Articles')
@push('css')
    <link rel="stylesheet" href="{{asset('libs/select2/css/select2.min.css')}}">
    <link href="{{asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('libs/daterangepicker/css/daterangepicker.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('libs/dropify/css/dropify.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/spectrum-colorpicker2/spectrum.min.css')}}">


@endpush
@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="articles-form" enctype="multipart/form-data" action="{{route('articles.sauvegarder')}}"
                          method="post"   autocomplete="off">
                        <!-- #####--Card Title--##### -->
                        <div class="card-title">
                            <div id="__fixed" class="d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{route('articles.liste')}}"><i class="fa fa-arrow-left"></i></a>
                                    <h5 class="m-0 float-end ms-3"><i class="fa  fas fa-boxes me-2 text-success"></i>
                                        Modifier un Article</h5>
                                </div>
                                <div class="pull-right">
                                    <button id="save-btn" class="btn btn-soft-info"><i class="fa fa-save"></i>
                                        Sauvegarder
                                    </button>
                                </div>
                            </div>
                            <hr class="border">
                        </div>
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 row mx-0 col-12">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">Informations</h5>
                                    <hr class="border border-success">
                                </div>
                                <div class=" col-12 col-lg-6 mb-3 ">
                                    <label class="form-label required" for="reference-input">Titre</label>
                                    <input  type="text"
                                            class="form-control {{$errors->has('titre')? 'is-invalid' : ''}}"
                                            id="titre" placeholder=""
                                            name="titre" value="{{old('titre', $article->title)}}">
                                    <div class="invalid-feedback">
                                        @if($errors->has('titre'))
                                            {{ $errors->first('titre') }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label required" for="categorie">Catégorie</label>
                                    <div class="input-group">
                                        <select
                                            class="select2 form-control mb-3 custom-select {{ $errors->has('categorie') ? 'is-invalid' : '' }}"
                                            name="categorie[]"
                                            id="categorie"
                                            multiple>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, $article->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if($errors->has('categorie'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('categorie') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-12 col-lg-6 mb-3 ">
                                    <label class="form-label   required" for="short_description">Description courte</label>
                                    <input  type="text"
                                            class="form-control {{$errors->has('short_description')? 'is-invalid' : ''}}"
                                            id="short_description"
                                            placeholder=""
                                            name="short_description" value="{{old('short_description', $article->short_description)}}">
                                    <div class="invalid-feedback">
                                        @if($errors->has('short_description'))
                                            {{ $errors->first('short_description') }}
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label required" for="desc-input">Description</label>
                                    <textarea name="description"
                                              class="form-control {{$errors->has('description')? 'is-invalid' : ''}}"
                                              style="resize: vertical"
                                              placeholder="Tapez votre description ici..." id="description" cols="30"
                                              rows="8">{{old('description', $article->description)}}</textarea>
                                    <div class="invalid-feedback">
                                        @if($errors->has('description'))
                                            {{ $errors->first('description') }}
                                        @endif
                                    </div>
                                </div>

                                {{--                                    <div class="col-12 col-lg-6 mb-3 ">--}}
                                {{--                                        <label for="i_image"--}}
                                {{--                                               class="form-label {{$errors->has('i_image')? 'is-invalid' : ''}}">Image</label>--}}
                                {{--                                        <input name="i_image" type="file" id="i_image" accept="image/*">--}}
                                {{--                                        <div class="invalid-feedback">--}}
                                {{--                                            @if($errors->has('i_image'))--}}
                                {{--                                                {{ $errors->first('i_image') }}--}}
                                {{--                                            @endif--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}

                            </div>
                            <div class="col-sm-6 row mx-0 a col-12 align-content-start">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">Prix</h5>
                                    <hr class="border border-success">
                                </div>
                                <div class="col-12 col-lg-6 mb-3 ">
                                    <label class="form-label   required" for="vente-input">Prix de vente</label>
                                    <div class="input-group">
                                        <input required type="number" step="0.01"
                                               class="form-control {{$errors->has('sale_price')? 'is-invalid' : ''}}"
                                               id="sale_price" min="0"
                                               name="sale_price" value="{{old('sale_price',$article->sale_price)}}">
                                        <span class="input-group-text">MAD</span>
                                        <div class="invalid-feedback">
                                            @if($errors->has('sale_price'))
                                                {{ $errors->first('sale_price') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-lg-6 mb-3 ">
                                    <label class="form-label   " for="price">Prix d'achat</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0"
                                               class="form-control {{$errors->has('price')? 'is-invalid' : ''}}"
                                               id="price"
                                               name="price" value="{{old('price', $article->price)}}">
                                        <span class="input-group-text">MAD</span>
                                        <div class="invalid-feedback">
                                            @if($errors->has('price'))
                                                {{ $errors->first('price') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="family-modal" tabindex="-1" aria-labelledby="add-cat-modal-title" aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title align-self-center" id="add-cat-modal-title">Ajouter une famille</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="family-form" action="{{route('categories.sauvegarder')}}" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label required " for="nom-input">Nom</label>
                                <input type="text" required class="form-control" id="nom-input" name="i_nom">
                                <div class="invalid-feedback">Veuillez d'abord entrer un nom</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="color-input" class="form-label">Couleur</label>
                                <input type="text" name="i_couleur" class="form-control " value="#3b5461" id="couleur-input">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check-inline d-flex align-items-center">
                                <label for="" class="form-check-label me-2" >Active</label>
                                <input name="i_actif" value="1" type="checkbox" id="active-input" switch="bool" checked="">
                                <label for="active-input" data-on-label="Oui" data-off-label="Non"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection
@push('scripts')
    <script src="{{asset('libs/spectrum-colorpicker2/spectrum.min.js')}}" ></script>
    <script src="{{asset('libs/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('libs/daterangepicker/js/daterangepicker.js')}}"></script>
    <script src="{{asset('libs/dropify/js/dropify.min.js')}}"></script>
    {{--    @vite('resources/js/article_create.js')--}}

    <script>
        $("#i_image").dropify({
            messages: {
                default: "Glissez-déposez un fichier ici ou cliquez",
                replace: "Glissez-déposez un fichier ou cliquez pour remplacer",
                remove: "Supprimer",
                error: "Désolé, le fichier trop volumineux",
            },
        });

        $("#marque").select2({
            allowClear : true,
            placeholder: "...",
            minimumResultsForSearch: -1,
        });
    </script>
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
@endpush
