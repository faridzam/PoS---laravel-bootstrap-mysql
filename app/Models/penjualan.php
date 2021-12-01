<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    use HasFactory;
    protected $fillable = ['id_produk', 't_id', 'nama_produk', 'harga_produk', 'kuantitas', 'jumlah'];
}
