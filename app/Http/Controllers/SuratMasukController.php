<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\KategoriSurat; // Pastikan nama Model sesuai dengan file Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Menampilkan daftar surat dengan fitur Search & Filter.
     */
    public function index(Request $request)
    {
        // 1. Ambil data kategori untuk dropdown filter
        $kategoris = KategoriSurat::all();

        // 2. Siapkan Query Builder
        $query = SuratMasuk::with(['kategori', 'creator']);

        // 3. Logika SEARCH (Pencarian)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('perihal', 'like', "%{$search}%")
                  ->orWhere('asal_surat', 'like', "%{$search}%")
                  ->orWhere('nomor_agenda', 'like', "%{$search}%");
            });
        }

        // 4. Logika FILTER Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // 5. Urutkan & Paginate (withQueryString agar search tidak hilang saat pindah page)
        $surats = $query->latest('tanggal_diterima')
                        ->paginate(10)
                        ->withQueryString();

        return view('surat-masuk.index', compact('surats', 'kategoris'));
    }

    /**
     * Menampilkan Form Tambah.
     */
    public function create()
    {
        $kategoris = KategoriSurat::all();
        return view('surat-masuk.create', compact('kategoris'));
    }

    /**
     * Proses Simpan Data Baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_agenda'      => 'required|string|max:255',
            'nomor_surat_asal'  => 'required|string|max:255',
            'asal_surat'        => 'required|string|max:255',
            'tanggal_surat'     => 'required|date',
            'tanggal_diterima'  => 'required|date',
            'perihal'           => 'required|string|max:255',
            'kategori_id'       => 'required|exists:kategori_surats,id', // Sesuaikan nama tabel kategori di DB
            'isi_ringkas'       => 'required',
            'lampiran_file'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Upload File
        if ($request->hasFile('lampiran_file')) {
            $path = $request->file('lampiran_file')->store('surat-masuk', 'public');
            $validated['lampiran_file'] = $path;
        }

        // Set Default Value
        $validated['created_by'] = auth()->id();
        $validated = $request->validate([
            'status_disposisi' => 'required|in:Pending,Diproses,Selesai,Diarsipkan',
        ]);

        SuratMasuk::create($validated);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat Masuk berhasil ditambahkan!');
    }

    /**
     * Menampilkan Detail Surat.
     */
    public function show($id)
    {
        $suratMasuk = SuratMasuk::with(['kategori', 'creator'])->findOrFail($id);
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    /**
     * Menampilkan Form Edit.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        $kategoris = KategoriSurat::all();
        return view('surat-masuk.edit', compact('suratMasuk', 'kategoris'));
    }

    /**
     * Proses Update Data.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'nomor_agenda'      => 'required',
            'nomor_surat_asal'  => 'required',
            'asal_surat'        => 'required',
            'tanggal_surat'     => 'required|date',
            'tanggal_diterima'  => 'required|date',
            'perihal'           => 'required',
            'kategori_id'       => 'required',
            'isi_ringkas'       => 'required',
            'status_disposisi'  => 'required|in:Pending,Proses,Selesai,Arsip', // Validasi Status
            'lampiran_file'     => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Cek Upload File Baru
        if ($request->hasFile('lampiran_file')) {
            // Hapus file lama
            if ($suratMasuk->lampiran_file && Storage::disk('public')->exists($suratMasuk->lampiran_file)) {
                Storage::disk('public')->delete($suratMasuk->lampiran_file);
            }
            // Simpan file baru
            $path = $request->file('lampiran_file')->store('surat-masuk', 'public');
            $validated['lampiran_file'] = $path;
        }

        $suratMasuk->update($validated);

        return redirect()->route('surat-masuk.index')->with('success', 'Data surat berhasil diperbarui!');
    }

    /**
     * Hapus Data.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        // Hapus file fisik
        if ($suratMasuk->lampiran_file && Storage::disk('public')->exists($suratMasuk->lampiran_file)) {
            Storage::disk('public')->delete($suratMasuk->lampiran_file);
        }
        
        $suratMasuk->delete();
        
        return redirect()->route('surat-masuk.index')->with('success', 'Surat berhasil dihapus!');
    }
}