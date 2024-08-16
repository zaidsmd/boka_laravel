@extends('layouts.main')
@section('document-title', 'تعيين كلمة المرور')
@section('page')
    <section>
        <div class="row">
            <div class="col-lg-6 d-flex justify-content-center">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <h4>تعيين كلمة المرور</h4>
                        <hr class="border">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" name="password" id="password"
                                       class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary text-white">تعيين كلمة المرور</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
