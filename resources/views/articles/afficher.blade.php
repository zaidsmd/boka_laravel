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
                        <!-- #####--Card Title--##### -->
                        <div class="card-title">
                            <div class="d-flex switch-filter justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('articles.liste') }}"><i class="fa fa-arrow-left"></i></a>
                                    <h5 class="m-0 float-end ms-3"><i class="mdi mdi-contacts me-2 text-success"></i>
                                        Voir l'article : {{$o_article->title}}
                                    </h5>
                                </div>
                                <a class="btn btn-soft-warning" href="{{route('articles.modifier',$o_article->id)}}"><i
                                        class="fa fa-edit"></i> Modifier</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4  col-md-6 col-12">
                <div class="card overflow-hidden">
                    <div class="rounded overflow-hidden "
                         style="max-width: 100%">
{{--                            <img src="{{route('article.image.load', $o_article->title)}}"--}}
{{--                                 class="border-0 w-100" alt="">--}}
                            <img src="https://placehold.co/150x150?text={{$o_article->title}}"
                                 class="border-0 w-100" alt="">
                    </div>
                    <div class="card-body overflow-hidden p-0">
                        <div class="row mx-0">
                            <div class="col-12 p-5 py-3 text-center d-flex flex-column align-items-center">
                                <h5 class="text-center text-primary-50 mt-3 mb-0">
                                    <strong>{{ strtoupper($o_article->title) }}</strong>

                                @if($o_article->categories->isNotEmpty())
                                        <br>
                                        Categorie:
                                        @foreach($o_article->categories as $category)
                                            {{ $category->name }}
                                            @if(!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9 col-xl-8 col-md-6 col-12 d-flex">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="card-title">
                            <h5>
                                Information d'article
                            </h5>
                            <hr class="border">
                        </div>
                        <div class="row">
                            <div class=" col-xl-3 col-lg-6  my-1   d-flex align-items-center">
                                <div class="rounded bg-info  p-2 d-flex align-items-center justify-content-center"
                                     style="width: 49px">
                                    <i class="fa fa-filter text-white fa-2x"></i>
                                </div>
                                <div class="ms-3 ">
                                    <span class="font-weight-bolder font-size-sm">Title</span>
                                    <p class="mb-0 h5 text-black">{{$o_article->title ?? '---'}}</p>
                                </div>
                            </div>
                            <div class=" col-xl-3 col-lg-6  my-1  d-flex align-items-center">
                                <div class="rounded bg-success  p-2 d-flex align-items-center justify-content-center"
                                     style="width: 49px">
                                    <i class="fa fa-dollar-sign text-white fa-2x"></i>
                                </div>
                                <div class="ms-3 ">
                                    <span class="font-weight-bolder font-size-sm">Prix de vente</span>
                                    <p class="mb-0 h5 text-black">{{$o_article->price ?? '0'}} MAD</p>
                                </div>
                            </div>
                            <div class=" col-xl-3 col-lg-6  my-1 d-flex align-items-center">
                                <div class="rounded bg-danger  p-2 d-flex align-items-center justify-content-center"
                                     style="width: 49px">
                                    <i class="fa fa-coins text-white fa-2x"></i>
                                </div>
                                <div class="ms-3 ">
                                    <span class="font-weight-bolder font-size-sm">Prix reduit</span>
                                    <p class="mb-0 h5 text-black">{{$o_article->sale_price ?? '0'}} MAD</p>
                                </div>
                            </div>

                            <div class=" col-xl-3 col-lg-6  my-1   d-flex align-items-center">
                                <div class="rounded bg-warning  p-2 d-flex align-items-center justify-content-center"
                                     style="width: 49px">
                                    <i class="fa fa-percent text-white fa-2x"></i>
                                </div>
                                <div class="ms-3 ">
                                    <span class="font-weight-bolder font-size-sm">Quantite</span>
                                    <p class="mb-0 h5 text-black">{{$o_article->quantite ?? '0'}}</p>
                                </div>
                            </div>

                            <div class=" col-xl-3 col-lg-6 col-12  my-3 d-flex align-items-center">
                                <div class="rounded bg-soft-info  p-2 d-flex align-items-center justify-content-center"
                                     style="width: 49px">
                                    <i class="fa fa-warehouse fa-2x"></i>
                                </div>
                                <div class="ms-3 ">
                                    <span class="font-weight-bolder font-size-sm">Description courte</span>
                                    <p class="mb-0 h5 text-black"> {{$o_article->short_description}}</p>
                                </div>
                            </div>
                            <div class=" col-xl-3 col-lg-6 col-12  my-3 d-flex align-items-center">
                                <div class="rounded bg-soft-success  p-2 d-flex align-items-center justify-content-center"
                                     style="width: 49px">
                                    <i class="fas fa-truck fa-2x"></i>
                                </div>
                                <div class="ms-3 ">
                                    <span class="font-weight-bolder font-size-sm">Description </span>
                                    <p class="mb-0 h5 text-black"> {{$o_article->description}}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
