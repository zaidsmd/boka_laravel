<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملخص طلبك</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            direction: rtl; /* Ensure RTL text direction */
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        .header {
            background: linear-gradient(-90deg, #ff7d2d, #ffc107);
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 5px;
        }
        .content {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: right; /* Align text to the right for RTL */
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right; /* Align text to the right for RTL */
        }
        .text-muted {
            color: #6c757d;
        }
        .text-bold {
            font-weight: bold;
        }
    </style>
</head>
<body dir="rtl">
<div class="container">
    <div class="header">
        <h1>شكرا لك. لقد تم استلام طلبك.</h1>
        <h1>نحن نعمل الآن على معالجة طلبك وسنوافيك بالتحديثات قريبًا.</h1>


    </div>
    <div class="content">
        <table>
            <tr>
                <td class="text-bold">رقم الطلب:</td>
                <td class="text-bold text-end">{{$order->number}}</td>
            </tr>
            <tr>
                <td class="text-bold">التاريخ:</td>
                <td class="text-bold text-end">{{$order->created_at->translatedFormat('M d ,Y')}}</td>
            </tr>
            <tr>
                <td class="text-bold">المجموع:</td>
                <td class="text-bold text-end">{{number_format($order->total,2,',',' ')}} د.م</td>
            </tr>
            <tr>
                <td class="text-bold">طريقة الدفع:</td>
                <td class="text-bold text-end">{{$order->payment_method}}</td>
            </tr>
        </table>

        <div class="card">
            <h2 class="card-header" style="text-align: right;">تفاصيل الطلب</h2>
            <div class="card-body">
                <table>
                    <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>الثمن</th>
                        <th>المجموع</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->lines as $line)
                        <tr>
                            <td>{{$line->article_title}} x{{$line->quantity}}</td>
                            <td class="text-center">{{$line->quantity}}</td>
                            <td class="text-end">{{number_format($line->price,2,',',' ')}} د.م</td>
                            <td class="text-end">{{number_format($line->price * $line->quantity,2,',',' ')}} د.م</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-bold">المجموع الفرعي:</td>
                        <td class="text-end text-bold">{{number_format($order->total - $order->shipping_fee,2,',',' ')}} د.م</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-bold">الشحن:</td>
                        <td class="text-end text-bold">{{number_format($order->shipping_fee,2,',',' ')}} د.م</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-bold">المجموع:</td>
                        <td class="text-end text-bold">{{number_format($order->total,2,',',' ')}} د.م</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <table>
            <tr>
                <td class="text-bold"> <h2>عنوان وصول الفواتير</h2>  </td>
                <td class="text-bold">    <h2>عنوان الشحن </h2></td>
            </tr>
            <tr>
                <td>
                    <p><strong>الاسم الأول:</strong> {{$order->first_name}}</p>
                    <p><strong>الاسم الأخير:</strong> {{$order->last_name}}</p>
                    <p><strong>المدينة:</strong> @lang('city.'.$order->city)</p>
                    <p><strong>الهاتف:</strong> {{$order->phone_number}}</p>
                    <p><strong>العنوان:</strong> {{$order->address}}</p>
                    <p><strong>البريد الالكتروني:</strong> {{$order->email}}</p>
                </td>
                <td>
                    <p><strong>الاسم الأول:</strong> {{$order->shipping_address?->first_name ?? $order->first_name}}</p>
                    <p><strong>الاسم الأخير:</strong> {{$order->shipping_address?->last_name ?? $order->last_name}}</p>
                    <p><strong>المدينة:</strong> @lang('city.'.($order->shipping_address?->city ?? $order->city))</p>
                    <p><strong>العنوان:</strong> {{$order->shipping_address?->address ?? $order->address}}</p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
