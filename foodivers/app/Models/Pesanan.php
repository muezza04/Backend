<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pesanan extends Model
{
    // relasi database pesanan dengan user() yaitu one-to-many
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    // relasi database pesanan dengan detail_pesanan(), yaitu one-to-many
    public function detail_pesanan()
    {
        return $this->hasMany('App\DetailPesanan', 'pesanan_id', 'id');
    }
}
