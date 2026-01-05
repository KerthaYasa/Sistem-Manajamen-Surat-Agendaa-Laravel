<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::with(['kategori', 'creator']);

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('perihal', 'like', '%'.$search.'%')
                ->orWhere('tujuan_surat', 'like', '%'.$search.'%') // Sesuaikan dengan field di DB
                ->orWhere('nomor_surat', 'like', '%'.$search.'%');
            });
        }

        // Urutkan dari yang terbaru
        $surats = $query->latest('tanggal_surat')->paginate(10);
        $kategoris = KategoriSurat::all();

        return view('surat-keluar.index', compact('surats', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriSurat::all();
        return view('surat-keluar.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_agenda'  => 'required',
            'nomor_surat'   => 'required',
            'tujuan_surat'  => 'required',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required',
            'kategori_id'   => 'required',
            // PERBAIKAN: Wajib required karena di database tidak nullable
            'isi_ringkas'   => 'required', 
            'status'        => 'nullable', 
            'lampiran_file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        if ($request->hasFile('lampiran_file')) {
            $validated['lampiran_file'] = $request->file('lampiran_file')->store('surat-keluar', 'public');
        }

        $validated['created_by'] = auth()->id();
        
        // Logika default status (agar tidak error column cannot be null)
        $validated['status'] = $request->status ?? 'Draft';

        SuratKeluar::create($validated);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat Keluar berhasil disimpan!');
    }

    public function show($id)
    {
        $suratKeluar = SuratKeluar::with(['kategori', 'creator', 'agendas'])->findOrFail($id);
        return view('surat-keluar.show', compact('suratKeluar'));
    }

    public function edit($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $kategoris = KategoriSurat::all();
        return view('surat-keluar.edit', compact('suratKeluar', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        $validated = $request->validate([
            'nomor_agenda'  => 'required',
            'nomor_surat'   => 'required',
            'tujuan_surat'  => 'required',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required',
            'kategori_id'   => 'required',
            // PERBAIKAN: Wajib required karena di database tidak nullable
            'isi_ringkas'   => 'required',
            'status'        => 'required', // Saat edit status wajib dipilih
            'lampiran_file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        if ($request->hasFile('lampiran_file')) {
            if ($suratKeluar->lampiran_file) {
                Storage::disk('public')->delete($suratKeluar->lampiran_file);
            }
            $validated['lampiran_file'] = $request->file('lampiran_file')->store('surat-keluar', 'public');
        }

        $suratKeluar->update($validated);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat Keluar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        if ($suratKeluar->lampiran_file) {
            Storage::disk('public')->delete($suratKeluar->lampiran_file);
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')->with('success', 'Surat Keluar berhasil dihapus!');
    }
}