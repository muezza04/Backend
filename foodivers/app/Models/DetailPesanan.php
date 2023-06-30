<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    // relasi database DetailPesanan dengan Produk, yaitu one-to-many
    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'produk_id', 'id');
    }

    // relasi database DetailPesanan dengan pesanan(), yaitu one-to-many
    public function pesanan()
    {
        return $this->belongsTo('App\Pesanan', 'pesanan_id', 'id');
    }
}
