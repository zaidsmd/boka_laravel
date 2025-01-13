<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'address', 'city', 'phone_number', 'email', 'email_verified_at', 'password', 'remember_token', 'role','notifiable'
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function shipping_address(): HasOne
    {
        return $this->hasOne(ShippingAddress::class);
    }
    public function invoicing_address(): HasOne
    {
        return $this->hasOne(InvoicingAddress::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function member_orders(){
        return $this->hasMany(MemberOrder::class);
    }
}
