<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار طلب جديد</title>
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
        <h1>مرحبًا،</h1>
        <h1>تم تقديم طلب جديد على موقعك.</h1>

    </div>
    <div class="content">
        <table>
            <tr>
                <td class="text-bold">رقم الطلب:</td>
                <td class="text-bold text-end">{{$order->number}}</td>
            </tr>
            <tr>
                <td class="text-bold">اسم الزبون :</td>
                <td class="text-bold text-end">{{ $order->first_name . ' ' . $order->last_name }}</td>
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
            <tr>
                <td class="text-bold">البريد الإلكتروني للزبون:</td>
                <td class="text-bold text-end">{{$order->billing_email}}</td>
            </tr>
        </table>
    </div>
</div>
</body>

</html>
