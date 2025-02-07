@extends('back_office.admin_layouts.main')

@section('document-title', 'الإعدادات')
@section('section')
    <div class="col-12">
        <!-- Section des Jobs -->
        <div class="row mb-4">
            <!-- Jobs en attente -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="jobs-list">
                            <!-- Job en attente 1 -->
                            <div class="card mb-3 border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0 text-primary">المهام قيد الانتظار</h5>
                                    </div>
                                    <h6 class="mb-0 ">
                                        <i class="fas fa-clock me-1 "></i>
                                        {{$pending_jobs}}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jobs en attente -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="jobs-list">
                            <!-- Job en attente 1 -->
                            <div class="card mb-3 border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class=" mb-0 text-danger">  المهام الفاشلة</h5>
                                    </div>
                                    <h6 class="mb-0">
                                        <i class="fas fa-clock me-1"></i>
                                        {{$failed_jobs}}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        <!-- Section des paramètres SMTP existante -->
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                      action="{{ route('smtpSettings.mettre_a_jour') }}" class="needs-validation"
                      novalidate autocomplete="off">
                    <!-- #####--عنوان البطاقة--##### -->
                    <div class="card-title">
                        <div id="__fixed" class="d-flex switch-filter justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h5 class="m-0">إعدادات خدمات البريد</h5>
                            </div>
                            <div class="pull-right">
                                <button id="save-btn" class="btn btn-soft-info"><i class="fa fa-save"></i> حفظ</button>
                            </div>
                        </div>
                        <hr class="border">
                    </div>
                    @csrf
                    <div class="row col-12 mx-0">
                        <div class="col-6">
                            <table class="table table-bordered table-striped mt-3 rounded overflow-hidden">
                                <tr>
                                    <th>الخيار</th>
                                    <th>القيمة</th>
                                </tr>
                                <tr>
                                    <td>مضيف البريد</td>
                                    <td>
                                        <input type="text" name="host" class="form-control @error('host') is-invalid @enderror"
                                               value="{{ old('host', $smtp_settings->host ?? '') }}" required>
                                        @error('host')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>منفذ البريد</td>
                                    <td>
                                        <input type="text" name="port" class="form-control @error('port') is-invalid @enderror"
                                               value="{{ old('port', $smtp_settings->port ?? '') }}" required>
                                        @error('port')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>اسم مستخدم البريد</td>
                                    <td>
                                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                               value="{{ old('username', $smtp_settings->username ?? '') }}" required>
                                        @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>كلمة مرور البريد</td>
                                    <td>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                               value="{{ old('password', $smtp_settings->password ?? '') }}" required>
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <table class="table table-bordered table-striped mt-3 rounded overflow-hidden">
                                <tr>
                                    <td>تشفير البريد</td>
                                    <td>
                                        <select name="encryption" class="form-select @error('encryption') is-invalid @enderror">
                                            <option value="" @selected(old('encryption', $smtp_settings->encryption ?? '') == '')>اختر التشفير</option>
                                            <option value="tls" @selected(old('encryption', $smtp_settings->encryption ?? '') == 'tls')>TLS</option>
                                            <option value="ssl" @selected(old('encryption', $smtp_settings->encryption ?? '') == 'ssl')>SSL</option>
                                        </select>
                                        @error('encryption')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>عنوان المرسل</td>
                                    <td>
                                        <input dir="rtl" style="text-align: right;" type="email" name="from_address" class="form-control @error('from_address') is-invalid @enderror"
                                               value="{{ old('from_address', $smtp_settings->from_address ?? '') }}" required>
                                        @error('from_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>اسم المرسل</td>
                                    <td>
                                        <input type="text" name="from_name" class="form-control @error('from_name') is-invalid @enderror"
                                               value="{{ old('from_name', $smtp_settings->from_name ?? '') }}" required>
                                        @error('from_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
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
