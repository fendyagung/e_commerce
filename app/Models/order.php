<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'alamat_pengiriman_id',
        'no_invoice',
        'subtotal',
        'diskon',
        'ongkir',
        'total',
        'ekspedisi',
        'no_resi',
        'status_pembayaran',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alamat_pengiriman()
    {
        return $this->belongsTo(AlamatPengiriman::class, 'alamat_pengiriman_id');
    }

    public function detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
