<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_harga',
        'metode_pembayaran',
        'alamat',
        'status'
    ];

    // 1. Tambahkan relasi ke DetailTransaksi (PENTING)
    public function details()
    {
        // Pastikan nama model DetailTransaksi sudah benar
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    // 2. Tambahkan relasi ke User (untuk menampilkan nama pembeli di dashboard)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}