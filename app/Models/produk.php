<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    public $timestamps = true;
    protected $fillable = ['nama_produk', 'harga_produk', 'stok_produk'];

    /**
     * Get the user that owns the produk
     *
     * @return \Illuminate\Database\EloquidRelaid\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
