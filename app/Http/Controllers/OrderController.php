<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderSummaryEmail;
use App\Jobs\SendRegistrationEmail;
use App\Models\Article;
use App\Models\CartLine;
use App\Models\GlobalSetting;
use App\Models\Order;
use App\Models\OrderShippingAddress;
use App\Models\OrderLine;
use App\Models\User;
use App\Models\Ville;
use Carbon\Carbon;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{


    public function payOk(Request $request)
    {
       return redirect()->route('order.confirmations',$request->oid);
    }
    public function payFail(Request $request){
        $order = Order::where('number', $request->get('oid'))->first();
        $order?->delete();
        return redirect()->route('cart.show',['failed_payment'=>1]);
    }

    /**
     * Display a listing of the resource.
     */
    public function completeOrder(Request $request)
    {
        $stockOperationsEnabled = GlobalSetting::where('nom', 'stock_operations')->value('valeur') == 1;

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|phone:INTERNATIONAL,MA',
            'email' => 'required|email',
            'city' => 'required|string',
            'other_city' => [
                'nullable',
                'required_if:city,other',
                'string',
            ],
            'address' => 'required|string',
            'payment_method' => 'required|in:transfert,cash,credit_card',
            'policy' => 'required|string',
            'shipping' => 'nullable|array',
            'shipping.first_name' => 'nullable|required_with:shipping|string',
            'shipping.last_name' => 'nullable|required_with:shipping|string',
            'shipping.address' => 'nullable|required_with:shipping|string',
            'shipping.city' => 'nullable|required_with:shipping',
            'other_shipping_city' => 'nullable|required_if:shipping.city,other|string',
        ]);

        $cart = cart();
        if (!$cart->cart_lignes()->count()) {
            session()->flash('danger', 'سلة المشتريات فارغة');
            return redirect()->route('cart.show');
        }
        DB::beginTransaction();
        try {
            $shipping_fee = $request->input('city') === 'other'
                ? 40
                : Ville::where('id', $request->input('city'))->value('price');
            if ($request->has('shipping')) {
                $shipping_fee = $request->input('shipping.city') === 'other' ? 40 :
                    Ville::where('id', $request->get('other_shipping_city'))->value('price');
            }
            if ($request->has('create_account')) {
                // Check if the user already exists
                $existingUser = User::where('email', $request->input('email'))->first();

                if ($existingUser) {
                    // If the user exists, log them in
                    session()->flash('warning', 'لم نتمكن من إنشاء حساب جديد لأنه موجود بالفعل');
                } else {
                    $existingToken = DB::table('password_reset_tokens')->where('email', $request->input('email'))->first();


                    if ($existingToken) {
                        // If a token exists, show a message that email has already been sent
                        session()->flash('success', 'تم إرسال بريد إلكتروني لتعيين كلمة المرور مسبقًا.');
                    } else {
                        $user = User::create([
                            'first_name' => $request->input('first_name'),
                            'last_name' => $request->input('last_name'),
                            'email' => $request->input('email'),
                            'password' => bcrypt($request->input('dummy')), // Hash the password
                            'role' => 'user', // Default role
                        ]);


                        // Log in the newly created user
                        $token = Str::random(60);
                        DB::table('password_reset_tokens')->insert([
                            'email' => $user->email,
                            'token' => $token,
                            'created_at' => now(),
                        ]);
                        $details = [
                            'email' => $user->email,
                            'token' => $token
                        ];
                        SendRegistrationEmail::dispatch($details);
                        session()->flash('success', ' يرجى التحقق من بريدك الإلكتروني لتعيين كلمة المرور');
                        auth()->login($user);

                    }


                }
            }

            $order = Order::create([
                'payment_method' => $request->input('payment_method') === 'cash' ? "نقدا عند الاستلام" : ($request->input('payment_method') === 'credit_card' ? "بطاقة بنكية" :  "تحويل مصرفي"),
                'status' => $request->input('payment_method') === 'credit_card' ? "في انتظار الدفع" : "قيد المعالجة",
                'billing_email' => $request->input('email'),
                'user_id' => auth()?->id() ?? null,
                'total' => $cart->total + $shipping_fee,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone_number' => $request->input('phone_number'),
                'city' => $request->input('city') === 'other' ? $request->get('other_city') : Ville::where('id', $request->get('city'))->value('nom'),
                'address' => $request->input('address'),
                'number' => $this->generateOrderNumber(),
                'type' => $request->has('shipping') ? '1' : '0',
                'shipping_fee' => $shipping_fee
            ]);
            if ($request->has('shipping')) {
                $shipping_address = OrderShippingAddress::create([
                    'first_name' => $request->input('shipping.first_name'),
                    'last_name' => $request->input('shipping.last_name'),
//                    'city' => $request->input('shipping.city'),
                    'city' => $request->input('shipping.city') === 'other' ? $request->get('other_shipping_city') : Ville::where('id', $request->get('shipping.city')),
                    'address' => $request->input('shipping.address'),
                    'order_id' => $order->id
                ]);
            }
            foreach ($cart->cart_lignes as $ligne) {
                OrderLine::create([
                    'article_id' => $ligne->article_id,
                    'article_title' => $ligne->article_title,
                    'price' => $ligne->article->sale_price ?? $ligne->article->price,
                    'quantity' => $ligne->quantity,
                    'order_id' => $order->id,
                ]);
                $article = Article::find($ligne->article_id);
                if ($stockOperationsEnabled) {
                    $article->update([
                        'quantite' => $article->quantite - $ligne->quantity
                    ]);
                }
            }
            if ($request->input('payment_method') === 'credit_card') {
                $cmi_data = [
                    "amount" => $order->total,
                    "BillToName" => $this->sanitizeInputFormCmi($order->first_name) . ' ' . $this->sanitizeInputFormCmi($order->last_name),
                    "CallbackResponse" => true,
                    "callbackUrl" => route('cmi-callback'),
                    "clientid" => "600005121",
                    "currency" => "504",
                    "email" => $order->billing_email,
                    "failUrl" => route('cmi-callback-failed'),
                    "hashAlgorithm" => "ver3",
                    "lang" => "ar",
                    "oid" => $order->number,
                    "okUrl" => route('cmi-callback-ok'),
                    "refreshtime" => "5",
                    "rnd" => now()->timestamp,
                    "storetype" => "3D_PAY_HOSTING",
                    "TranType" => "PreAuth",
                    'tel'=>$order->phone_number,
                    "BillTocompany"=>'Bokadobox',
                    "BillToCountry"=>"MA"
                ];
                $hash = $this->generateCmiHash($cmi_data);
            }else{
                CartLine::where('cart_id', $cart->id)->delete();
            }
            SendOrderSummaryEmail::dispatch($order);
            DB::commit();
            if (isset($cmi_data)) {
                $data = $cmi_data;
                return view('cmi-redirect-form', compact('data', 'hash'));
            }else {
                session()->flash('success', 'لقد أرسلنا لك بريدًا إلكترونيًا للتأكيد');
                return '<script>window.location="'.route('order.confirmations', $order->number).'"</script>';
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::driver('daily');
            Log::emergency($exception->getMessage() . ' ' . $exception->getFile() . ' ' . $exception->getLine() . ' ' . now()->format('d-m-Y H:i:s'));
            session()->flash('danger', 'حدث خطأ أثناء اتمام الطلب');
            return redirect()->route('cart.show');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function orderConfirmation(string $number)
    {
        $order = Order::where('number', $number)->first();
        if (!$order) {
            session()->flash('error', 'رقم الطلب غير صحيح');
            return redirect()->route('home');
        }
        return view('order-confirmation', compact('order'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $number)
    {
        $order = Order::with('lines')->where('number', $number)->first();
        return view('order-show', compact('order'));
    }


    public function cmiCallback(Request $request)
    {
        $order = Order::where('number', $request->get('oid'))->first();
        if($request->get("Response") == "Approved" && $order) {
            if ($request->get('ProcReturnCode') === "00") {
                session()->forget('cart');
                $order?->update(['status' => 'قيد المعالجة']);
                return response("ACTION=POSTAUTH");
            } else {
                return response("APPROVED");
            }
        } else {
            return response("FAILURE");
        }
    }



    function generateOrderNumber()
    {
        $date = Carbon::now()->format('ymisdH');
        $randomString = Str::upper(Str::random(3));
        $orderNumber = $randomString . $date;

        return $orderNumber;
    }

    function generateCmiHash($cmi_data)
    {
        $storekey = 'Bokadobox_a2024a';
        $hash = "";

        uksort($cmi_data,'strcasecmp');

        // Build the hash string by iterating over sorted keys
        foreach ($cmi_data as $key => $value) {
            $lower_key = strtolower($key);
            if ($lower_key != "hash" && $lower_key != "encoding") {
                $param_value = trim(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                $escaped_value = str_replace("|", "\\|", str_replace("\\", "\\\\", $param_value));
                $hash .= $escaped_value . "|";
            }
        }

        // Append the escaped storekey at the end
        $escaped_storekey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storekey));
        $hash .= $escaped_storekey;

        // Generate the SHA-512 hash and encode it in base64
        return base64_encode(pack("H*", hash('sha512', $hash)));
    }
    function sanitizeInputFormCmi($input) {
        // Remove special characters, retain letters, numbers, and spaces
        $sanitized = preg_replace('/[^a-zA-Z0-9 ]/', '', $input);
        // Trim leading and trailing spaces
        return trim($sanitized);
    }


}
