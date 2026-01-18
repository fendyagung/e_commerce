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
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kategori');
            $table->string('nama_kategori');
            $table->string('slug_kategori');
            $table->text('deskripsi_kategori')->nullable();
            $table->string('status')->default('publish');
            $table->string('foto')->nullable();
            $table->foreignId('user_id')->nullable(); // Optional: to track who created it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
