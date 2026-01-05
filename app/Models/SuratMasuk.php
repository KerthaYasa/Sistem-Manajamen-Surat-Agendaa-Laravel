<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $guarded = [];

    // Relasi ke Kategori (Untuk menampilkan nama kategori di tabel)
    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }

    // Relasi ke User (Siapa admin yang input)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke Agenda (Satu surat bisa jadi dasar banyak agenda)
    public function agendas()
    {
        return $this->hasMany(AgendaKegiatan::class, 'surat_masuk_id');
    }
}