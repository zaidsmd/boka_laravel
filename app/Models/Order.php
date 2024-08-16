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
    const STATUS_PROCESSING = 'قيد المعالجة';
    const STATUS_SHIPPED = 'مُرسل';
    const STATUS_DELIVERED = 'تم التوصيل';
    const STATUS_CANCELED = 'ملغى';

    // Status array
    public static function getStatuses()
    {
    return [
            self::STATUS_SHIPPED,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELED,
            self::STATUS_PROCESSING,
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
