<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'total',
        'billing_email',
        'payment_method',
        'user_id',
        'number',
        'shipping_fee',
        'type', 'first_name', 'last_name', 'city', 'address', 'phone_number',
    ];

    // Status constants
    const STATUS_PENDING = 'معلق';
    const STATUS_PROCESSING = 'قيد المعالجة';
    const STATUS_SHIPPED = 'مُرسل';
    const STATUS_DELIVERED = 'تم التوصيل';
    const STATUS_CANCELED = 'ملغى';
    const STATUS_ONHOLD = 'في الانتظار';

    // Status array
    public static function getStatuses()
    {
    return [
            self::STATUS_PENDING,
            self::STATUS_SHIPPED,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELED,
            self::STATUS_PROCESSING,
            self::STATUS_ONHOLD
        ];
    }


    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function shipping_address(){
        return $this->hasOne(OrderShippingAddress::class);
    }
}
