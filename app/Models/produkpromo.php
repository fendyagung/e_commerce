<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPromo extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan di database
    protected $table = 'produk_promos';

    // Kolom yang diizinkan untuk pengisian massal (mass assignment)
    protected $fillable = [
        'produk_id',
        'harga_awal',
        'harga_akhir',
        'diskon_persen',
        'diskon_nominal',
        'user_id',
    ];

    /**
     * Relasi ke model Produk (Setiap promo dimiliki oleh satu produk)
     */
    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }

    /**
     * Relasi ke model User (Setiap promo dicatat/dimiliki oleh satu user)
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}