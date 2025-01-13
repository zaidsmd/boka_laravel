<?php

namespace App\Http\Controllers;

use App\Models\InvoicingAddress;
use App\Models\ShippingAddress;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function updateAccountInfo(Request $request)
    {
       if ($request->ajax()){
           $request->validate([
               'first_name' => 'required|string|max:255',
               'last_name' => 'required|string|max:255',
               'email' => 'required|email|max:255',
               'current_password' => 'required_with:new_password|nullable|string|max:255|',
               'new_password' => 'required_with:current_password|nullable|string|max:255|min:8|',

           ], [
               'current_password.required_with' => 'يجب إدخال كلمة المرور الحالية عند تغيير كلمة المرور',
               'new_password.required_with' => 'يجب إدخال كلمة المرور الجديدة عند تغيير كلمة المرور',
               'new_password.min' => 'كلمة المرور يجب أن تتكون من 8 أحرف على الأقل.',

           ]);
           $user = $request->user();
           if ($request->input('current_password')) {
               if (!Hash::check($request->input('current_password'), $user->password)) {
                   return response(['errors'
                   => ['current_password' => ['كلمة المرور الحالية لا تتطابق مع سجلاتنا.']]], 422);
               }
           }
           $user->update([
               'first_name' => $request->input('first_name'),
               'last_name' => $request->input('last_name'),
               'email' => $request->input('email'),
               'password' => $request->input('new_password') ? Hash::make($request->get('new_password')) : $user->password
           ]);
           return response('تم تحديث معلوماتك بنجاح');
       }
       abort(404);
    }

    public function updateShippingAddress(Request $request)
    {
        if ($request->ajax()){
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'city' => 'required|string',
                'address' => 'required|string|max:255'
            ]);
            $user = $request->user();
            $city =Ville::where('id', $request->input('city'))->value('nom')? : 'other';
            $shipping_address = $user->shipping_address;
            if (!$shipping_address) {
                ShippingAddress::create([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'city' => $city,
                    'address' => $request->input('address'),
                    'user_id' => $user->id
                ]);
            } else {
                $shipping_address->update([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'city' => $city ,
                    'address' => $request->input('address'),
                ]);
            }
            $cart = cart();
            $cart->city = $city;
            $cart->save();
            return response('لقد تم تحديث عنوان الشحن الخاص بك بنجاح.');
        }
        abort(404);
    }
    public function updateInvoicingAddress(Request $request){
        if ($request->ajax()){
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone_number'=>'required|phone:INTERNATIONAL,MA',
                'email'=>'required|email'
            ]);
            $user = $request->user();
            $invoicing_address = $user->invoicing_address;
            if (!$invoicing_address) {
                InvoicingAddress::create([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'address' => $request->input('address'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'user_id' => $user->id
                ]);
            } else {
                $invoicing_address->update([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'address' => $request->input('address'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                ]);
            }
            return response('لقد تم تحديث عنوان الفاتورة الخاص بك بنجاح.');
        }
        abort(404);
    }
}
