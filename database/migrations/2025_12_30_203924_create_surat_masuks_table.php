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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda');       // No urut internal
            $table->string('nomor_surat_asal');   // No dari pengirim
            $table->date('tanggal_surat');        // Tgl tertera di surat
            $table->date('tanggal_diterima');     // Tgl surat sampai
            $table->string('asal_surat');         // Pengirim
            $table->string('perihal');
            
            // Relasi ke Kategori
            $table->foreignId('kategori_id')->constrained('kategori_surats')->onDelete('cascade');
            
            $table->text('isi_ringkas');
            $table->string('lampiran_file')->nullable(); // Path file upload
            $table->string('status_disposisi')->default('Belum Disposisi'); 
            
            // Relasi ke User (Siapa yang input)
            $table->foreignId('created_by')->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
