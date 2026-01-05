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
        Schema::create('agenda_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            
            // Relasi ke Jenis Agenda
            $table->foreignId('jenis_agenda_id')->constrained('jenis_agendas');
            
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('tempat');
            $table->text('keterangan')->nullable();
            $table->string('status')->default('Terjadwal'); // Terjadwal, Selesai, Batal
            
            // Relasi Opsional (Boleh Null)
            // nullOnDelete() artinya jika surat dihapus, agenda TIDAK ikut terhapus (hanya linknya putus)
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuks')->nullOnDelete();
            $table->foreignId('surat_keluar_id')->nullable()->constrained('surat_keluars')->nullOnDelete();
            
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
        Schema::dropIfExists('agenda_kegiatans');
    }
};
