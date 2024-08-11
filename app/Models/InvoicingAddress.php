<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicingAddress extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone_number',
        'email',
        'user_id',
    ];
}
