@extends('layouts.main')
@section('document-title', 'استعادة كلمة المرور')
@section('page')
    <section>
        <div class="row">
            <div class="col-lg-6 d-flex">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <h4>استعادة كلمة المرور</h4>
                        <hr class="border">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group my-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button class="btn btn-primary text-white">إرسال رابط إعادة تعيين كلمة المرور</button>
                        </form>
                        @if (session('status'))
                            <div class="alert alert-success mt-3">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
