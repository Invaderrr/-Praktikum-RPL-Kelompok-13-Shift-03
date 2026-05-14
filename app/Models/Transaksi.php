<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Nama tabel di database sesuai image_477c20.png
    protected $table = 'transaksi';

    // Primary key custom sesuai image_477c20.png
    protected $primaryKey = 'id_transaksi';

    /**
     * Karena tabel Anda tidak memiliki kolom created_at dan updated_at, 
     * kita harus menonaktifkan fitur timestamps otomatis Laravel.
     */
    public $timestamps = false;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'tanggal_transaksi',
        'jam_transaksi',
        'total_harga',
        'metode_pembayaran',
        'id_user'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        // jam_transaksi biasanya tipe time/string, jadi biarkan sebagai string agar aman
    ];


    // ==========================================
    // RELASI
    // ==========================================

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        // Sesuaikan 'id_transaksi' sebagai foreign key di tabel detail
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}