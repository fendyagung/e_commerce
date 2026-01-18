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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('no_invoice');
            $table->double('subtotal', 12, 2)->default(0);
            $table->double('diskon', 12, 2)->default(0);
            $table->double('ongkir', 12, 2)->default(0);
            $table->double('total', 12, 2)->default(0);
            $table->string('ekspedisi')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('status_pembayaran')->default('belum'); // belum, sudah
            $table->string('status')->default('checkout'); // checkout, diproses, dikirim, diterima
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
