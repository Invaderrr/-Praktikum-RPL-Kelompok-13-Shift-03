<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        // Mencatat user yang melakukan transaksi (ID dari tabel users)
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        // Menyimpan total harga (15 digit dengan 2 angka di belakang koma)
        $table->decimal('total_harga', 15, 2); 
        
        // Menyimpan metode (QRIS/Cash) dan alamat
        $table->string('metode_pembayaran');
        $table->text('alamat');
        
        // Status transaksi untuk mempermudah filter laporan di dashboard Admin
        $table->string('status')->default('success'); 
        
        $table->timestamps(); // Ini akan otomatis membuat kolom created_at (waktu transaksi)
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
