<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriSurat;
use App\Models\JenisAgenda;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // --- Isi Kategori Surat ---
        $kategori = [
            ['nama_kategori' => 'Surat Keputusan', 'deskripsi' => 'SK Pengangkatan, Pemberhentian, dll'],
            ['nama_kategori' => 'Surat Undangan', 'deskripsi' => 'Undangan Rapat, Acara Resmi'],
            ['nama_kategori' => 'Surat Permohonan', 'deskripsi' => 'Permohonan Izin, Cuti, Dana'],
            ['nama_kategori' => 'Surat Pemberitahuan', 'deskripsi' => 'Edaran, Pengumuman'],
            ['nama_kategori' => 'Nota Dinas', 'deskripsi' => 'Komunikasi Internal'],
        ];

        foreach ($kategori as $k) {
            KategoriSurat::create($k);
        }

        // --- Isi Jenis Agenda ---
        $agenda = [
            ['nama_jenis' => 'Rapat Internal', 'deskripsi' => 'Rapat rutin staff'],
            ['nama_jenis' => 'Rapat Koordinasi', 'deskripsi' => 'Rapat antar divisi/lembaga'],
            ['nama_jenis' => 'Kunjungan Dinas', 'deskripsi' => 'Perjalanan ke luar kota/instansi lain'],
            ['nama_jenis' => 'Menerima Tamu', 'deskripsi' => 'Kunjungan dari pihak luar'],
            ['nama_jenis' => 'Sosialisasi', 'deskripsi' => 'Penyuluhan atau seminar'],
        ];

        foreach ($agenda as $a) {
            JenisAgenda::create($a);
        }
    }
}