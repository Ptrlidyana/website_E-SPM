<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('no_po'); // Menambahkan kolom no_po (string)
            $table->date('tanggal'); // Menambahkan kolom tanggal (date)
            $table->string('nomer_polisi'); // Menambahkan kolom nomer_polisi (string)
            $table->decimal('volume', 8, 2); // Menambahkan kolom volume (decimal dengan 8 digit total dan 2 digit desimal)
            $table->string('nama_transportir'); // Menambahkan kolom nama_transportir (string)
            $table->string('nama_sopir'); // Menambahkan kolom nama_user (string)
            $table->string('file_upload')->nullable(); // Menambahkan kolom file_upload (string, nullable)
            $table->string('file_upload')->nullable(); // Menambahkan kolom file_upload (string, nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
