<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('alamat_pengiriman_id')->nullable();
            $table->string('no_invoice');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('ekspedisi')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('status_pembayaran')->default('belum'); // belum, sudah
            $table->string('status')->default('menunggu'); // menunggu, diproses, dikirim, selesai, batal
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alamat_pengiriman_id')->references('id')->on('alamat_pengiriman')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
