@extends('layouts.main')
@section('document-title', 'تعيين كلمة المرور')
@section('page')
    <section>
        <div class="row">
            <div class="col-lg-6 d-flex">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <h4>تعيين كلمة المرور</h4>
                        <hr class="border">
                        <form method="POST" action="{{ route('password.reset.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group my-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="password" class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="password-confirm" class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" id="password-confirm" name="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror">
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button class="btn btn-primary text-white">تعيين كلمة المرور</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
