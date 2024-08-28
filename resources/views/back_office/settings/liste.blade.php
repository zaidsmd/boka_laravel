@extends('back_office.admin_layouts.main')

@section('document-title', 'Settings')
@section('section')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                      action="{{ route('settings.mettre_a_jour') }}" class="needs-validation"
                      novalidate autocomplete="off">
                    <!-- #####--Card Title--##### -->
                    <div class="card-title">
                        <div id="__fixed" class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="m-0 float-end ms-3">
                                    <i class="mdi mdi-cog me-2 text-success"></i>
                                    إعدادات  عامة
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
                    @method('PUT')
                    <table class="table table-bordered table-striped mt-3 rounded overflow-hidden">
                        <tr>
                            <th>إعدادات</th>
                            <th>مفعلة</th>

                        </tr>
                        @foreach($settings as $set)
                            <tr>
                                <td>
                                    <label class="form-label me-3"
                                           for="module-{{$set->id}}">{{$set->label}}</label>
                                </td>
                                <td>
                                    <input name="{{$set->nom}}[valeur]" value="1" type="checkbox" id="set-{{$set->id}}" switch="bool" @checked(old('valeur',$set->valeur)) >
                                    <label for="set-{{$set->id}}" data-on-label="نعم" data-off-label="لا"></label>
                                </td>

                            </tr>
                        @endforeach
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
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
@endpush
