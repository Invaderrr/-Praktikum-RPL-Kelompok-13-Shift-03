<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    // Tambahkan ini agar data item belanja bisa disimpan
    protected $fillable = [
        'transaksi_id',
        'nama_item',
        'harga_satuan',
        'jumlah',
        'subtotal'
    ];

    /**
     * Relasi balik ke Transaksi utama
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}