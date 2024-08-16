@extends('layouts.main')
@section('document-title','لوحة حسابي')
@section('page')
    @if($auth)
        <section>
            <ul class="nav nav-tabs" id="accoutn-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane"
                            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"/>
                    <span class="mx-1"> <i class="fa fa-user"></i> </span><span class="d-md-inline d-none"> تفاصيل الحساب</span>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping-tab-pane"
                            type="button" role="tab" aria-controls="shipping-tab-pane" aria-selected="false"><span
                            class="mx-1"><i class="fa fa-truck"></i></span>
                        <span class="d-md-inline d-none">عنوان الشحن</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#invoicing-tab-pane"
                            type="button" role="tab" aria-controls="invoicing-tab-pane" aria-selected="false"><span
                            class="mx-1"><i class="fa fa-file-invoice"></i></span>
                        <span class="d-md-inline d-none">
                            عنوان الفاتورة
                        </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane"
                            type="button" role="tab" aria-controls="order-tab-pane" aria-selected="false"><span
                            class="mx-1"><i class="fa fa-boxes"></i></span>
                        <span class="d-md-inline d-none">الطلبات</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            type="button" role="tab" id="logout"><span class="mx-1"><i
                                class="fa fa-right-from-bracket"></i></span>
                        <span class="d-md-inline d-none">تسجيل الخروج</span>
                    </button>
                </li>
            </ul>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel" aria-labelledby="info-tab"
                     tabindex="0">
                    <form action="{{route('profile.update-account-info')}}" method="post" class="form-my-account">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="first_name" class="form-label required">الإسم الأول</label>
                                    <input type="text" id="first_name" name="first_name"
                                           value="{{old('first_name',$auth->first_name)}}"
                                           class="form-control @error('first_name') is-invalid @enderror">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="last_name" class="form-label required">الإسم الأخير</label>
                                    <input type="text" id="last_name" name="last_name"
                                           value="{{old('last_name',$auth->last_name)}}"
                                           class="form-control @error('last_name') is-invalid @enderror">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="email" class="form-label required">البريد الإلكتروني</label>
                                    <input type="email" id="email" name="email" value="{{old('email',$auth->email)}}"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <h5 class="mt-3">تغيير كلمة المرور</h5>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="current-password" class="form-label">كلمة المرور الحالية (اترك الحقل
                                        فارغاً إذا كنت لا تودّ تغييرها)</label>
                                    <div class="input-group password-input-group">
                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                        <span class="input-group-text d-none"><i class="fa fa-eye-slash"></i></span>
                                        <input type="password" name="current_password" id="current-password"
                                               class="form-control @error('current_password') is-invalid @enderror">
                                        @error('current_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="new-password" class="form-label">كلمة المرور الجديدة (اترك الحقل فارغاً
                                        إذا كنت لا تودّ تغييرها)</label>
                                    <div class="input-group password-input-group">
                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                        <span class="input-group-text d-none"><i class="fa fa-eye-slash"></i></span>
                                        <input type="password" name="new_password" id="new-password"
                                               class="form-control @error('new_password') is-invalid @enderror">
                                        @error('new_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button class="btn btn-primary text-white">حفظ التغييرات</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="shipping-tab-pane" role="tabpanel" aria-labelledby="shipping-tab"
                     tabindex="0">
                    <form action="{{route('profile.update-shipping-address')}}" method="post" class="form-my-account">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="first_name-shipping" class="form-label required">الإسم الأول</label>
                                    <input type="text" id="first_name-shipping" name="first_name"
                                           value="{{old('first_name',$auth->shipping_address?->first_name)}}"
                                           class="form-control @error('first_name') is-invalid @enderror">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="last_name-shipping" class="form-label required">الإسم الأخير</label>
                                    <input type="text" id="last_name-shipping" name="last_name"
                                           value="{{old('last_name',$auth->shipping_address?->last_name)}}"
                                           class="form-control @error('last_name') is-invalid @enderror">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="city-shipping" class="form-label required">المدينة</label>
                                    <select name="city" class="form-select" id="city-shipping">
                                        <option
                                            @selected(old('city', $auth->shipping_address?->city) == 'tangier') value="tangier">
                                            طنجة
                                        </option>
                                        <option
                                            @selected(old('city', $auth->shipping_address?->city) == 'other' ) value="other">
                                            مدينة مغربية أخرى
                                        </option>
                                    </select>
                                    @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="address-shipping" class="form-label required">العنوان</label>
                                    <input type="text" id="address-shipping" name="address"
                                           value="{{old('address',$auth->shipping_address?->address)}}"
                                           class="form-control @error('address') is-invalid @enderror">
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary text-white">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="invoicing-tab-pane" role="tabpanel" aria-labelledby="invoicing-tab"
                     tabindex="0">
                    <form action="{{route('profile.update-invoicing-address')}}" method="post" class="form-my-account">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="first_name-invoicing" class="form-label required">الإسم الأول</label>
                                    <input type="text" id="first_name-invoicing" name="first_name"
                                           value="{{old('first_name',$auth->invoicing_address?->first_name)}}"
                                           class="form-control @error('first_name') is-invalid @enderror">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="last_name-invoicing" class="form-label required">الإسم الأخير</label>
                                    <input type="text" id="last_name-invoicing" name="last_name"
                                           value="{{old('last_name',$auth->invoicing_address?->last_name)}}"
                                           class="form-control @error('last_name') is-invalid @enderror">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="phone_number-invoicing" class="form-label required">الهاتف</label>
                                    <input type="text" id="phone_number-invoicing" name="phone_number"
                                           value="{{old('phone_number',$auth->invoicing_address?->phone_number)}}"
                                           class="form-control @error('phone_number') is-invalid @enderror">
                                    @error('phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="email-invoicing" class="form-label required">البريد الإلكتروني</label>
                                    <input type="text" id="email-invoicing" name="email"
                                           value="{{old('email',$auth->invoicing_address?->email)}}"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 my-2">
                                <div class="form-group">
                                    <label for="address-invoicing" class="form-label required">العنوان</label>
                                    <input type="text" id="address-invoicing" name="address"
                                           value="{{old('address',$auth->invoicing_address?->address)}}"
                                           class="form-control @error('address') is-invalid @enderror">
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary text-white">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade pt-4" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab"
                     tabindex="0">
                    <div class="orders-list">
                        <div class="row ">
                            <h6 class="col-md-4 col-6">الطلب</h6>
                            <h6 class="col-md-3 col-4">التاريخ</h6>
                            <h6 class="col-3 d-none d-md-block">المجموع</h6>
                            <h6 class="col-2">الأفعال</h6>
                        </div>
                        @foreach($auth->orders as $order)
                            <div class="row py-2 bg-white my-2 border rounded">
                                <div class="col-md-4 col-6">{{$order->number}}</div>
                                <div class="col-md-3 col-4">{{$order->created_at->format('d/m/Y')}}</div>
                                <div class="col-3 d-none d-md-block">{{number_format($order->total + $order->shipping_fee,2,',',' ')}}د.م
                                </div>
                                <div class="col-2">
                                    <button data-order="{{$order->number}}" class="btn order-show-btn btn-primary btn-sm btn-rounded text-white"><span
                                            class="fa fa-eye"></span></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="order-show d-none">

                    </div>
                </div>
            </div>
        </section>
    @else
        <section>
            <div class="row">
                <div class="col-lg-6 d-flex">
                    <div class="card border-0 shadow-sm w-100">
                        <div class="card-body">
                            <h4>تسجيل جديد</h4>
                            <hr class="border">
                            <!-- Display status message -->
                            @if(session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="post" action="{{ route('register') }}">
                                @csrf
                                <label for="email-reg" class="form-label">البريد الإلكتروني</label>
                                <input type="email" id="email-reg" name="email_reg"
                                       class="form-control @error('email_reg') is-invalid @enderror">
                                @error('email_reg')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <p class="mt-2">
                                    سيتم إرسال رابط لتعيين كلمة مرور جديدة إلى عنوان بريدك الإلكتروني.
                                    <br>
                                    سيتم استخدام بياناتك الشخصية لدعم تجربتك في هذا الموقع، ولإدارة الوصول إلى حسابك،
                                    <br>
                                    ولأغراض أخرى تم توضيحها في <a href=""> سياسة الخصوصية</a> لدينا.
                                </p>
                                <button class="btn btn-primary text-white">سجل الان</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex">
                    <div class="card border-0 shadow-sm w-100">
                        <div class="card-body">
                            <h4>تسجيل الدخول</h4>
                            <hr class="border">
                            <form action="{{ route('auth.login') }}" method="post">
                                @csrf
                                <div class="form-group my-3">
                                    <label for="email-log" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" id="email-log" name="email"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="password-log" class="form-label">الرمز السري</label>
                                    <div class="input-group password-input-group">
                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                        <span class="input-group-text d-none"><i class="fa fa-eye-slash"></i></span>
                                        <input type="password" name="password" id="password-log"
                                               class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary text-white">تسجيل الدخول</button>
                            </form>
                            <div class="mt-3">
                                <a href="{{ route('password.request') }}" class="text-decoration-none">نسيت كلمة المرور؟</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
