public function up(): void
{
    Schema::create('bahan_baku', function (Blueprint $table) {
        $table->id();
        $table->string('nama_item');
        $table->string('kategori');
        $table->integer('stok');
        $table->integer('stok_min');
        $table->string('satuan');
        $table->integer('harga');
        $table->timestamps();
    });
}