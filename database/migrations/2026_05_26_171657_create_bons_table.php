<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bons', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->decimal('jumlah_bayar', 10, 2)->default(0);
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->date('tanggal_bon');
            $table->date('tanggal_lunas')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bons');
    }
};