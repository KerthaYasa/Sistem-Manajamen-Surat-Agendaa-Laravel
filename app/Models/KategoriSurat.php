<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSurat extends Model
{
    // Agar kita bisa langsung simpan data tanpa define satu-satu
    protected $guarded = []; 

    public function suratMasuks()
    {
        return $this->hasMany(SuratMasuk::class, 'kategori_id');
    }

    public function suratKeluars()
    {
        return $this->hasMany(SuratKeluar::class, 'kategori_id');
    }
}