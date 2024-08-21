<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملخص الطلب</title>
</head>
<body>
<h2>ملخص طلبك</h2>

<p>مرحباً {{ $order->first_name }}  {{ $order->last_name }},</p>

<p>شكراً لطلبك! إليك ملخص طلبك:</p>

<ul>
    @foreach($order->lines as $item)
        <li>{{ $item->article_title }} - {{ $item->quantity }} x {{ $item->price }}  درهم </li>
    @endforeach
</ul>

<p><strong>الإجمالي:</strong> {{ $order->total }} درهم </p>

<p>نشكر لك شرائك.</p>

<p>مع خالص التحيات،</p>
<p>Bokadobox </p>
</body>
</html>
