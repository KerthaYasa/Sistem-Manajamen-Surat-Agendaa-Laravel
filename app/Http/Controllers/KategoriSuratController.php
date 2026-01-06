<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    // Menampilkan halaman list kategori
public function index(Request $request)
    {
        // 1. Inisialisasi query
        $query = KategoriSurat::query();

        // 2. Cek apakah ada request 'search' dari form pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            
            // 3. Lakukan filter berdasarkan nama_kategori ATAU deskripsi
            $query->where(function($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // 4. Ambil data (gunakan get() atau paginate() jika data banyak)
        // Menggunakan latest() agar data terbaru muncul paling atas
        $kategoris = $query->latest()->get();

        return view('master.kategori.index', compact('kategoris'));
    }

    // Menampilkan FORM tambah kategori (Method ini yang menyebabkan error sebelumnya)
    public function create()
    {
        return view('master.kategori.create');
    }

    // Menyimpan data dari form tambah
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_surats,nama_kategori',
            'deskripsi'     => 'nullable|string'
        ]);
        
        KategoriSurat::create($request->all());
        
        return redirect()->route('kategori-surat.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // Menampilkan halaman detail (Show)
    public function show(KategoriSurat $kategoriSurat)
    {
        return view('master.kategori.show', compact('kategoriSurat'));
    }

    // Menampilkan FORM edit
    public function edit(KategoriSurat $kategoriSurat)
    {
        return view('master.kategori.edit', compact('kategoriSurat'));
    }

    // Menyimpan perubahan data (Update)
    public function update(Request $request, KategoriSurat $kategoriSurat)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_surats,nama_kategori,' . $kategoriSurat->id,
            'deskripsi'     => 'nullable|string'
        ]);

        $kategoriSurat->update($request->all());
        
        return redirect()->route('kategori-surat.index')->with('success', 'Kategori berhasil diupdate');
    }

    // Menghapus data
    public function destroy(Request $request, $id)
    {
        // Cari Kategori berdasarkan ID
        $kategoriSurat = KategoriSurat::findOrFail($id);

        // ==========================================
        // BAGIAN 1: EKSEKUSI HAPUS PAKSA (Force Delete)
        // ==========================================
        if ($request->has('force_delete')) {
            // 1. Hapus semua Surat Masuk yang pakai kategori ini
            $kategoriSurat->suratMasuks()->delete();

            // 2. Hapus semua Surat Keluar yang pakai kategori ini
            $kategoriSurat->suratKeluars()->delete();

            // 3. Terakhir, hapus Kategori itu sendiri
            $kategoriSurat->delete();

            return back()->with('success', 'Kategori beserta seluruh Surat Masuk & Keluar terkait BERHASIL dihapus.');
        }

        // ==========================================
        // BAGIAN 2: CEK KEAMANAN (Validation)
        // ==========================================
        
        // Hitung pemakaian di Surat Masuk
        $jumlahMasuk = $kategoriSurat->suratMasuks()->count();
        
        // Hitung pemakaian di Surat Keluar
        $jumlahKeluar = $kategoriSurat->suratKeluars()->count();

        // Total pemakaian
        $total = $jumlahMasuk + $jumlahKeluar;

        // Jika dipakai minimal 1 kali (baik di masuk atau keluar)
        if ($total > 0) {
            // Buat pesan detail
            $pesan = "Kategori ini sedang digunakan oleh: ";
            if ($jumlahMasuk > 0) $pesan .= "$jumlahMasuk Surat Masuk ";
            if ($jumlahKeluar > 0) $pesan .= "dan $jumlahKeluar Surat Keluar";
            $pesan .= ". Apakah Anda yakin ingin menghapus semuanya?";

            // Kembalikan ke View untuk memicu SweetAlert Merah
            return back()->with('confirm_deletion', [
                'id' => $kategoriSurat->id,
                'message' => $pesan
            ]);
        }

        // ==========================================
        // BAGIAN 3: HAPUS NORMAL (Jika tidak dipakai)
        // ==========================================
        $kategoriSurat->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
}