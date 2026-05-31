<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bon extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'total_harga',
        'jumlah_bayar',
        'status',
        'tanggal_bon',
        'tanggal_lunas',
        'catatan',
    ];

    public function items()
    {
        return $this->hasMany(BonItem::class);
    }
}