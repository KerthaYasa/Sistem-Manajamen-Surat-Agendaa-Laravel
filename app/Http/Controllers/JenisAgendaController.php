<?php

namespace App\Http\Controllers;

use App\Models\JenisAgenda;
use Illuminate\Http\Request;

class JenisAgendaController extends Controller
{
    /**
     * Menampilkan daftar Jenis Agenda dengan fitur PENCARIAN
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi Query
        $query = JenisAgenda::query();

        // 2. Cek input pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            
            // Filter berdasarkan nama_jenis ATAU deskripsi
            $query->where(function($q) use ($search) {
                $q->where('nama_jenis', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // 3. Ambil data (urutkan dari yang terbaru)
        $jenisAgendas = $query->latest()->get();

        return view('master.jenis-agenda.index', compact('jenisAgendas'));
    }

    /**
     * Menampilkan FORM tambah
     */
    public function create()
    {
        return view('master.jenis-agenda.create');
    }

    /**
     * Menyimpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_agendas,nama_jenis',
            'deskripsi'  => 'nullable|string'
        ]);

        JenisAgenda::create([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi'  => $request->deskripsi
        ]);

        // Redirect ke halaman index setelah simpan
        return redirect()->route('jenis-agenda.index')->with('success', 'Jenis Agenda berhasil ditambahkan!');
    }

    /**
     * Menampilkan DETAIL data (Show) - Mengatasi Error 500 Anda
     */
    public function show(JenisAgenda $jenisAgenda)
    {
        return view('master.jenis-agenda.show', compact('jenisAgenda'));
    }

    /**
     * Menampilkan FORM edit
     */
    public function edit(JenisAgenda $jenisAgenda)
    {
        return view('master.jenis-agenda.edit', compact('jenisAgenda'));
    }

    /**
     * Mengupdate data
     */
    public function update(Request $request, JenisAgenda $jenisAgenda)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_agendas,nama_jenis,' . $jenisAgenda->id,
            'deskripsi'  => 'nullable|string'
        ]);

        $jenisAgenda->update([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi'  => $request->deskripsi
        ]);

        // Redirect ke halaman index setelah update
        return redirect()->route('jenis-agenda.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data
     */
    public function destroy(Request $request, $id) // Perhatikan parameter $id kita ambil manual biar fleksibel
    {
        $jenisAgenda = JenisAgenda::findOrFail($id);

        // 1. Cek apakah user mengirim sinyal "force_delete" (Hapus Paksa)
        if ($request->has('force_delete')) {
            // HAPUS SEMUA ANAKNYA DULU (Agenda Kegiatan)
            $jenisAgenda->agendas()->delete(); 
            
            // BARU HAPUS BAPAKNYA (Jenis Agenda)
            $jenisAgenda->delete();

            return back()->with('success', 'Data Jenis Agenda dan seluruh Agenda Kegiatan terkait BERHASIL dihapus.');
        }

        // 2. Jika tidak ada sinyal paksa, Cek apakah datanya dipakai?
        if ($jenisAgenda->agendas()->count() > 0) {
            // Jangan hapus dulu! Kembali ke view dengan membawa ID dan pesan konfirmasi
            return back()->with('confirm_deletion', [
                'id' => $jenisAgenda->id,
                'message' => 'Jenis Agenda ini sedang dipakai oleh ' . $jenisAgenda->agendas()->count() . ' data Agenda Kegiatan. Apakah Anda yakin ingin menghapus semuanya?'
            ]);
        }

        // 3. Jika data bersih (tidak dipakai), hapus normal
        $jenisAgenda->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}