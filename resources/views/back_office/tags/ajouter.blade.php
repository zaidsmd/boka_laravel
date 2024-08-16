@extends('back_office.admin_layouts.main')
@section('document-title','Users')
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
                    <form id="articles-form" enctype="multipart/form-data" action="{{route('utilisateurs.sauvegarder')}}"
                          method="post"   autocomplete="off">
                        @csrf
                        <!-- #####--Card Title--##### -->
                        <div class="card-title">
                            <div id="__fixed" class="d-flex switch-filter justify-content-between align-items-center">
                                <div>
                                    <a href="{{route('utilisateurs.liste')}}"><i class="fa fa-arrow-left"></i></a>
                                    <h5 class="m-0 float-end ms-3">
                                        <i class="mdi me-2 text-success mdi-account-group"></i>
                                        إضافة مستخدم
                                    </h5>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-soft-info"><i class="fa fa-save"></i> حفظ</button>
                                </div>

                            </div>
                            <hr class="border">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="first_name" class="form-label required">الاسم الشخصي</label>
                                <input id="first_name" type="text" class="form-control @error('first_name')  is-invalid @enderror "
                                       name="first_name" value="{{old('first_name')}}">
                                @error('first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="last_name" class="form-label required">الاسم العائلي</label>
                                <input id="last_name" type="text" class="form-control @error('last_name')  is-invalid @enderror "
                                       name="last_name" value="{{old('last_name')}}">
                                @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="email-input" class="form-label required">البريد الإلكتروني</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror "
                                       name="email" value="{{old('email')}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label for="password " class="form-label required">كلمة المرور</label>
                                <div class="input-group">
                                    <input type="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror "
                                           name="password" value="{{old('password')}}">
                                    <button class="btn btn-light show-pass" type="button"><i class="fa fa-eye"></i>
                                    </button>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
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
    <script src="{{asset('libs/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('libs/daterangepicker/js/daterangepicker.js')}}"></script>
    <script src="{{asset('libs/dropify/js/dropify.min.js')}}"></script>

    <script src="{{asset('libs/filepond/plugins/js/filepond-plugin-image-preview.js')}}"></script>
    <script src="{{asset('libs/filepond/js/filepond.js')}}"></script>
    <script src="{{asset('libs/filepond/plugins/js/filepond-plugin-image-validate-size.js')}}"></script>
    <script src="{{asset('libs/filepond/plugins/js/filepond-plugin-file-validate-type.js')}}"></script>


    <script>
        $('.show-pass').click(function () {
            if ($('#password').attr('type') === 'password') {
                $('#password').attr('type', 'text')
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash')
            } else {
                $('#password').attr('type', 'password')
                $(this).find('i').addClass('fa-eye').removeClass('fa-eye-slash')
            }
        })
        $("#i_image").dropify({
            messages: {
                default: "",
                replace: "",
                remove: "",
                error: "",
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
            acceptedFileTypes: ['image/*'],
            maxFileSize: '2MB',
            allowMultiple: true,
            storeAsFile: true
        });
    </script>

@endpush
