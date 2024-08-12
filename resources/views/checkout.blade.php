@extends('layouts.main')
@section('page')
    <form action="{{route('complete-checkout')}}" method="post">
        <div class="row">
            @csrf
            <div class="col-6">
                <h4>تفاصيل الفاتورة</h4>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label for="first_name-invoicing" class="form-label required">الإسم الأول</label>
                            <input type="text" id="first_name-invoicing" name="first_name"
                                   value="{{old('first_name')}}"
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
                                   value="{{old('last_name')}}"
                                   class="form-control @error('last_name') is-invalid @enderror">
                            @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="phone_number-invoicing" class="form-label required">الهاتف</label>
                            <input type="text" id="phone_number-invoicing" name="phone_number"
                                   value="{{old('phone_number')}}"
                                   class="form-control @error('phone_number') is-invalid @enderror">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="email-invoicing" class="form-label required">البريد الإلكتروني</label>
                            <input type="text" id="email-invoicing" name="email"
                                   value="{{old('email')}}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="city-invoicing" class="form-label required">المدينة</label>
                            <select name="city" id="city-invoicing" class="form-select">
                                <option
                                    @selected(cart()->city === 'tangier') value="tangier">@lang('city.tangier')</option>
                                <option
                                    @selected(cart()->city === 'other') value="other">@lang('city.other')</option>
                            </select>
                            @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="address-invoicing" class="form-label required">العنوان</label>
                            <input type="text" id="address-invoicing" name="address"
                                   value="{{old('address')}}"
                                   class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6  shipping-side">
                <h4><input type="checkbox" class="form-check-input mx-2 shipping-checkbox">عنوان الشحن مختلف</h4>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label for="first_name-shipping" class="form-label required">الإسم الأول</label>
                            <input type="text" id="first_name-shipping" name="shipping[first_name]" disabled
                                   value="{{old('shipping.first_name')}}"
                                   class="form-control @error('shipping.first_name') is-invalid @enderror">
                            @error('shipping.first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label for="last_name-shipping" class="form-label required">الإسم الأخير</label>
                            <input type="text" id="last_name-shipping" name="shipping[last_name]" disabled
                                   value="{{old('shipping.last_name')}}"
                                   class="form-control @error('shipping.last_name') is-invalid @enderror">
                            @error('shipping.last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="city-shipping" class="form-label required">المدينة</label>
                            <select name="shipping[city]" id="city-shipping" class="form-select" disabled>
                                <option
                                    @selected(old('shipping.city',cart()->city)=== 'tangier') value="tangier">@lang('city.tangier')</option>
                                <option
                                    @selected(old('shipping.city',cart()->city)=== 'other') value="other">@lang('city.other')</option>
                            </select>
                            @error('shipping.city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="form-group">
                            <label for="address-invoicing" class="form-label required">العنوان</label>
                            <input type="text" id="address-shipping" name="shipping[address]" disabled
                                   value="{{old('shipping.address')}}"
                                   class="form-control @error('shipping.address') is-invalid @enderror">
                            @error('shipping.address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="bg-orange-400 rounded p-3">
                    <h5 class="text-white"> طرق الدفع</h5>
                    <div class="payment-option active p-3 rounded my-3 mt-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <label for="payement_transfert" class="form-check-label w-100">تحويل مصرفي مباشر </label>
                            <input id="payement_transfert" type="radio" checked name="payment_method"
                                   class="form-check-input" value="transfert">
                        </div>
                        <p class="text-muted " style="font-size: 13px">
                            قم بإجراء الدفع مباشرة في حسابنا المصرفي. يرجى استخدام رقم الطلب الخاص بك كمرجع للدفع. لن
                            يتم شحن طلبك حتى يتم تحويل الأموال إلى الحساب التالي
                            MME IELMAKI IKRAM : 007640001077530040024157
                        </p>
                    </div>
                    <div class="payment-option p-3 rounded my-3 ">
                        <div class="d-flex align-items-center justify-content-between">
                            <label for="cash" class="form-check-label w-100">الدفع نقدًا عند الاستلام </label>
                            <input id="cash" type="radio" name="payment_method" class="form-check-input" value="cash">
                        </div>
                    </div>
                    <hr class="border-white">
                    <p class="text-muted">
                        سيتم استخدام بياناتك الشخصية لمعالجة طلبك، ودعم تجربتك في هذا الموقع، ولأغراض أخرى تم توضيحها في
                        سياسة الخصوصية لدينا.
                    </p>
                    <div class="d-flex align-items-center ">
                        <div class="bg-white p-1 px-2 ms-2 rounded">
                            <input id="policy" type="checkbox" name="policy" class="form-check-input" value="transfert">
                        </div>
                        <label for="policy" class="form-check-label w-100 required text-muted">لقد قرأتُ الشروط والأحكام
                            وأوافق عليها لهذا الموقع</label>
                    </div>
                    <div class="col-12 text-start my-2">
                        <button class="btn bg-white text-primary">أتمم الطلب</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
