<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonItem extends Model
{
    protected $fillable = [
        'bon_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}