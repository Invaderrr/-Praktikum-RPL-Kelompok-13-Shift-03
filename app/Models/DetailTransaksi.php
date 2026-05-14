<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $primaryKey = 'id_detail';

    public $timestamps = false;

    protected $fillable = [
        'jumlah',
        'harga_satuan',
        'subtotal',
        'id_transaksi',
        'id_bahan_baku'
    ];

    // RELASI TRANSAKSI
    public function transaksi()
    {
        return $this->belongsTo(
            Transaksi::class,
            'id_transaksi'
        );
    }

    // RELASI BAHAN BAKU
    public function bahanBaku()
    {
        return $this->belongsTo(
            BahanBaku::class,
            'id_bahan_baku'
        );
    }
}