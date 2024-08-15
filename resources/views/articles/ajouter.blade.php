@extends('admin_layouts.main')
@section('document-title',__('lang.articles.titre'))
@push('css')
    <link rel="stylesheet" href="{{asset('libs/select2/css/select2.min.css')}}">
    <link href="{{asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('libs/daterangepicker/css/daterangepicker.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('libs/dropify/css/dropify.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/spectrum-colorpicker2/spectrum.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/filepond/plugins/css/filepond-plugin-image-preview.css')}}">
    <link rel="stylesheet" href="{{asset('libs/filepond/css/filepond.css')}}">
    <link href="{{ asset('libs/summernote/summernote.min.css') }}" rel="stylesheet">


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
                                         إضافة منتج</h5>
                                </div>
                                <div class="pull-right">
                                    <button id="save-btn" class="btn btn-soft-info"><i class="fa fa-save"></i>
                                        {{__('lang.articles.save')}}
                                    </button>
                                </div>
                            </div>
                            <hr class="border">
                        </div>
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 row mx-0 col-12 align-content-start">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">  {{__('lang.articles.info')}}</h5>
                                    <hr class="border border-success">
                                </div>
                                <div class=" col-12 col-lg-6 mb-3 ">
                                    <label class="form-label required" for="reference-input">  {{__('lang.articles.title')}}</label>
                                    <input  type="text"
                                           class="form-control {{$errors->has('titre')? 'is-invalid' : ''}}"
                                           id="titre" placeholder=""
                                           name="titre" value="{{old('titre')}}">
                                    <div class="invalid-feedback">
                                        @if($errors->has('titre'))
                                            {{ $errors->first('titre') }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 mb-3 ">
                                    <label class="form-label required" for="categorie">  {{__('lang.articles.category')}}</label>
                                    <div class="input-group">
                                        <select
                                            class="select2 form-control mb-3 custom-select {{$errors->has('categorie')? 'is-invalid' : ''}}"
                                            name="categorie[]"
                                            id="categorie" multiple>
                                        </select>

                                        {{--<button type="button" class="btn btn-light" data-bs-target="#family-modal" data-bs-toggle="modal" >+</button>--}}
                                        @if($errors->has('categorie'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('categorie') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 mb-3 ">
                                    <label class="form-label required" for="tag">  الوسوم</label>
                                    <div class="input-group">
                                        <select
                                            class="select2 form-control mb-3 custom-select {{$errors->has('tag')? 'is-invalid' : ''}}"
                                            name="tag[]"
                                            id="tag" multiple>
                                        </select>

                                        {{--<button type="button" class="btn btn-light" data-bs-target="#family-modal" data-bs-toggle="modal" >+</button>--}}
                                        @if($errors->has('tag'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('tag') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 mb-3 ">
                                    <label class="form-label   required" for="quantite"> {{__('lang.articles.quantity')}}</label>
                                    <div class="input-group">
                                        <input  type="number" step="1"
                                                class="form-control {{$errors->has('quantite')? 'is-invalid' : ''}}"
                                                id="quantite"
                                                name="quantite" value="{{old('quantite')}}">
                                        <div class="invalid-feedback">
                                            @if($errors->has('quantite'))
                                                {{ $errors->first('quantite') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-12 mb-3 ">

                                    <label class="form-label required" for="description">  الوصف</label>
                                    <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                </div>


                            </div>
                            <div class="col-sm-6 row mx-0 a col-12 align-content-start">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">  سعر و صور</h5>
                                    <hr class="border border-success">
                                </div>

                                <div class=" col-12 col-lg-6 mb-3 ">
                                    <label class="form-label  required " for="price">  {{__('lang.articles.sale_price')}} </label>
                                    <div class="input-group">
                                        <input type="number" step="1" min="0"
                                               class="form-control {{$errors->has('price')? 'is-invalid' : ''}}"
                                               id="price"
                                               name="price" value="{{old('price')}}">
                                        <span class="input-group-text">MAD</span>
                                        <div class="invalid-feedback">
                                            @if($errors->has('price'))
                                                {{ $errors->first('price') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-lg-6 mb-3 ">
                                    <label class="form-label   " for="vente-input">  {{__('lang.articles.reduit_price')}}</label>
                                    <div class="input-group">
                                        <input  type="number" step="1"
                                               class="form-control {{$errors->has('sale_price')? 'is-invalid' : ''}}"
                                               id="sale_price"
                                               name="sale_price" value="{{old('sale_price')}}">
                                        <span class="input-group-text">MAD</span>
                                        <div class="invalid-feedback">
                                            @if($errors->has('sale_price'))
                                                {{ $errors->first('sale_price') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 mb-3 ">
                                    <label for="i_image"
                                           class="form-label {{$errors->has('i_image')? 'is-invalid' : ''}}">  الصورة الرئيسية</label>
                                    <input name="i_image" type="file" id="i_image" accept="image/*" >
                                    <div class="invalid-feedback">
                                        @if($errors->has('i_image'))
                                            {{ $errors->first('i_image') }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 mb-3 ">

                                    <label for="i_images" class="form-label">  صور إضافية</label>
                                    <input type="file" id="i_images" name="i_images[]" multiple>
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


    <script src="{{ asset('libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/tinymce_ar.js') }}"></script>

    <script>
        $("#i_image").dropify({
            messages: {
                default: 'اسحب وأفلت ملفًا هنا أو انقر لاختيار ملف',
                replace: 'اسحب وأفلت ملفًا هنا لاستبداله',
                remove: 'إزالة',
                error: 'عذرًا، حدث خطأ'
            },
        });


    </script>
    <script>
        $("#categorie").select2({
            placeholder: "البحث عن فئة",
            language : 'ar',
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
        $("#tag").select2({
            placeholder: "البحث عن وسم",
            language : 'ar',
            ajax: {
                url: "{{ route('tags.select') }}",
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
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginImageValidateSize
        );

        // Get a reference to the file input element
        const inputElement = document.querySelector('input[id="i_images"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            labelIdle: 'اسحب وأفلت ملفًا هنا أو انقر لاختيار ملف',
            labelInvalidField: 'الحقل يحتوي على ملفات غير صالحة',
            labelFileWaitingForSize: 'في انتظار الحجم',
            labelFileSizeNotAvailable: 'الحجم غير متاح',
            labelFileLoading: 'جارٍ التحميل',
            labelFileLoadError: 'حدث خطأ أثناء التحميل',
            labelFileProcessing: 'جارٍ الرفع',
            labelFileProcessingComplete: 'تم الرفع',
            labelFileProcessingAborted: 'تم إلغاء الرفع',
            labelFileProcessingError: 'حدث خطأ أثناء الرفع',
            labelFileProcessingRevertError: 'حدث خطأ أثناء التراجع',
            labelFileRemoveError: 'حدث خطأ أثناء الإزالة',
            labelTapToCancel: 'انقر للإلغاء',
            labelTapToRetry: 'انقر لإعادة المحاولة',
            labelTapToUndo: 'انقر للتراجع',
            labelButtonRemoveItem: 'إزالة',
            labelButtonAbortItemLoad: 'إيقاف',
            labelButtonRetryItemLoad: 'إعادة المحاولة',
            labelButtonAbortItemProcessing: 'إلغاء',
            labelButtonUndoItemProcessing: 'تراجع',
            labelButtonRetryItemProcessing: 'إعادة المحاولة',
            labelButtonProcessItem: 'رفع',
            acceptedFileTypes: ['image/*'],
            maxFileSize: '2MB',
            allowMultiple: true,
            storeAsFile: true
        });
    </script>
    <script>
        const  __tinymce_toolbar  = 'fontsizeselect bold | forecolor backcolor | lists | code | table | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat';
        const __tinymce_plugins = [
            'advlist','paste','textcolor', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ];
        tinymce.init({
            selector: "#description",
            height: 300,
            menubar: !0,
            oninit: "setPlainText",
            plugins: __tinymce_plugins,
            toolbar: __tinymce_toolbar,
            language : 'ar',
            toolbar_mode: "floating",
            content_style:
                "body { font-family:Helvetica,Arial,sans-serif; font-size:16px }",
        });
    </script>
@endpush
