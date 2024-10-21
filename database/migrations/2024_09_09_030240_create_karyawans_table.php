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
            $table->string('no_po'); // Nomer PO
            $table->date('tanggal'); // Tanggal
            $table->string('nomer_polisi'); // Nomer Polisi
            $table->decimal('volume', 8, 2); // Volume
            $table->string('nama_transportir'); // Nama Transportir
            $table->string('nama_user'); // Nama User atau Sopir
            $table->string('file_upload')->nullable(); // File Upload, nullable jika tidak ada
            $table->string('file_upload_2')->nullable(); // File Upload tambahan
            $table->timestamps(); // Timestamps (created_at dan updated_at)
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

