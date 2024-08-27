<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        h2 {
            background: orange;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            width: 40%; /* Adjust width as needed */
            margin: 20px auto; /* Center the header and add vertical margin */
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        body {
            text-align: center;
            direction: rtl;
            padding: 20px; /* Add padding to prevent content from touching edges */

        }
    </style>
</head>
<body dir="rtl " style="text-align: center">
<h2>إعادة تعيين كلمة المرور</h2>
<p>لقد طلبت إعادة تعيين كلمة المرور الخاصة بك.</p>
<p>لإعادة تعيين كلمة المرور، يرجى النقر على الرابط أدناه:</p>
<a href="{{ $resetLink }}">إعادة تعيين كلمة المرور</a>
<p>إذا لم تطلب إعادة تعيين كلمة المرور، فلا داعي لاتخاذ أي إجراء آخر.</p>
</body>
</html>
