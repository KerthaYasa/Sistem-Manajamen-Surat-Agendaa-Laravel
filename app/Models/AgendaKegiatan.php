<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaKegiatan extends Model
{
    protected $guarded = [];

    // Mengambil Detail Jenis Agenda (Rapat, Dinas, dll)
    public function jenisAgenda()
    {
        return $this->belongsTo(JenisAgenda::class, 'jenis_agenda_id');
    }

    // Mengambil Detail Surat Masuk (Jika agenda berdasarkan surat masuk)
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    // Mengambil Detail Surat Keluar
    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class, 'surat_keluar_id');
    }

    // Siapa yang membuat jadwal ini
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}