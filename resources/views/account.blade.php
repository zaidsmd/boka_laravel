@extends('layouts.main')
@section('page')
    <section>
        <div class="row">
            <div class="col-lg-6 d-flex   ">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <h4>تسجيل جديد</h4>
                        <hr class="border">
                        <form action="">
                            @csrf
                            <label for="email-reg" class="form-label">البريد الإلكتروني</label>
                            <input type="email" id="email-reg" class="form-control">
                            <p class="mt-2">
                                سيتم إرسال رابط لتعيين كلمة مرور جديدة إلى عنوان بريدك الإلكتروني.
                                <br>
                                سيتم استخدام بياناتك الشخصية لدعم تجربتك في هذا الموقع، ولإدارة الوصول إلى حسابك،
                                <br>
                                ولأغراض أخرى تم توضيحها في <a href=""> سياسة الخصوصية</a> لدينا.
                            </p>
                            <button class="btn btn-primary text-white" >سجل الان</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex    ">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <h4>تسجيل الدخول</h4>
                        <hr class="border">
                        <form action="">
                            @csrf
                            <div class="form-group my-3">
                                <label for="email-log" class="form-label">البريد الإلكتروني</label>
                                <input type="email" id="email-log" class="form-control">
                            </div>
                            <div class="form-group my-3">
                                <label for="password-log" class="form-label">الرمز السري</label>
                                <input type="password" id="password-log" class="form-control">
                            </div>
                            <button class="btn btn-primary text-white" >تسجيل الدخول</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
