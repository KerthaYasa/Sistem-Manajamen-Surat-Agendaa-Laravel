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
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda');
            $table->string('nomor_surat');        // No surat yang kita keluarkan
            $table->date('tanggal_surat');
            $table->string('tujuan_surat');       // Kepada siapa
            $table->string('perihal');
            $table->string('status')->default('Draft'); // Draft, Dikirim, Diarsipkan
            
            // Relasi ke Kategori
            $table->foreignId('kategori_id')->constrained('kategori_surats')->onDelete('cascade');
            
            $table->text('isi_ringkas');
            $table->string('lampiran_file')->nullable();
            
            // Relasi ke User
            $table->foreignId('created_by')->constrained('users');
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
