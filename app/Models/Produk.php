<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProdukImage;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'slug_produk',
        'deskripsi_produk',
        'kategori_id',
        'qty',
        'satuan',
        'harga',
        'status',
        'foto',
        'user_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(ProdukImage::class, 'produk_id');
    }

    public function promos()
    {
        return $this->hasMany(ProdukPromo::class, 'produk_id');
    }
}
