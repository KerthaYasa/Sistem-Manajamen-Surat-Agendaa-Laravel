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
    public function destroy(KategoriSurat $kategoriSurat)
    {
        $kategoriSurat->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
}