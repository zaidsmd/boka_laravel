<?php

namespace App\Http\Controllers;

use App\Models\CartLine;
use App\Models\Order;
use App\Models\OrderShippingAddress;
use App\Models\OrderLine;
use Carbon\Carbon;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function completeOrder(Request $request)
    {
        $request->validate([
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'phone_number'=>'required|phone:INTERNATIONAL,MA',
            'email'=>'required|email',
            'city'=>'required|in:tangier,other',
            'address'=>'required|string',
            'payment_method'=>'required|in:transfert,cash',
            'policy'=>'required|string',
            'shipping'=>'nullable|array',
            'shipping.first_name'=>'nullable|required_with:shipping|string',
            'shipping.last_name'=>'nullable|required_with:shipping|string',
            'shipping.address'=>'nullable|required_with:shipping|string',
            'shipping.city'=>'nullable|required_with:shipping|in:tangier,other',
        ]);
        $cart = cart();
        if (!$cart->cart_lignes()->count()){
            session()->flash('danger','سلة المشتريات فارغة');
            return redirect()->route('cart.show');
        }
        DB::beginTransaction();
        try {
            $shipping_fee = $request->input('city') ==='tangier' ? 25 : 40;
            if ($request->has('shipping')){
                $shipping_fee = $request->input('shipping.city') ==='tangier' ? 25 : 40;
            }
            $order = Order::create([
                'payment_method' => $request->input('payment_method') === 'cash' ? "نقدا عند الاستلام" : "تحويل مصرفي",
                'status' =>  $request->input('payment_method') === 'cash' ? "قيد المعالجة" : "في الانتظار",
                'billing_email' => $request->input('email'),
                'user_id' => auth()?->id() ?? null,
                'total' => $cart->total + $shipping_fee,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone_number' => $request->input('phone_number'),
                'city' => $request->input('city'),
                'address' => $request->input('address'),
                'number'=> $this->generateOrderNumber(),
                'type' => $request->has('shipping') ? '1' : '0',
                'shipping_fee'=>$shipping_fee
            ]);
            if ($request->has('shipping')){
                $shipping_address = OrderShippingAddress::create([
                    'first_name' => $request->input('shipping.first_name'),
                    'last_name' => $request->input('shipping.last_name'),
                    'city' => $request->input('shipping.city'),
                    'address' => $request->input('shipping.address'),
                    'order_id' => $order->id
                ]);
            }
            foreach ($cart->cart_lignes as $ligne){
                OrderLine::create([
                    'article_id' => $ligne->article_id,
                    'article_title' => $ligne->article_title,
                    'price' => $ligne->article->sale_price ?? $ligne->article->price,
                    'quantity' => $ligne->quantity,
                    'order_id'=> $order->id,
                ]);
            }
            CartLine::where('cart_id',$cart->id)->delete();
            DB::commit();
            return redirect()->route('order.confirmations',$order->number);
        }catch (\Exception $exception){
            DB::rollBack();
            Log::driver('daily');
            Log::emergency($exception->getMessage() . ' '.$exception->getFile().' '.$exception->getLine(). ' '. now()->format('d-m-Y H:i:s'));
            session()->flash('danger','حدث خطأ أثناء اتمام الطلب');
            return redirect()->route('cart.show');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function orderConfirmation(string $number)
    {
        $order = Order::where('number',$number)->first();
        if (!$order){
            session()->flash('error','رقم الطلب غير صحيح');
            return redirect()->route('home');
        }
        return  view('order-confirmation',compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
    function generateOrderNumber()
    {
        $date = Carbon::now()->format('ymisdH');
        $randomString = Str::upper(Str::random(3));
        $orderNumber = $randomString . $date ;

        return $orderNumber;
    }
}
