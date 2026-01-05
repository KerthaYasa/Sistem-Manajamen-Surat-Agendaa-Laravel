<?php

namespace App\Http\Controllers;

use App\Models\AgendaKegiatan;
use App\Models\JenisAgenda;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class AgendaKegiatanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query Builder
        $query = AgendaKegiatan::with(['jenisAgenda', 'suratMasuk', 'suratKeluar', 'creator']);

        // 2. Logika Searching (Berdasarkan Nama Kegiatan atau Tempat)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%");
            });
        }

        // 3. Logika Filter Dropdown (Berdasarkan Jenis Agenda)
        if ($request->filled('jenis_agenda_id')) {
            $query->where('jenis_agenda_id', $request->jenis_agenda_id);
        }

        // 4. Logika Filter Status (Opsional, jika ingin filter status juga)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Eksekusi Query dengan Pagination
        // withQueryString() penting agar saat pindah halaman (page 2), filter tidak reset
        $agendas = $query->latest()
                         ->paginate(10)
                         ->withQueryString();

        // Ambil data JenisAgenda untuk isi Dropdown Filter di View
        $jenisAgendas = JenisAgenda::all();

        return view('agenda.index', compact('agendas', 'jenisAgendas'));
    }

    public function create()
    {
        $jenisAgendas = JenisAgenda::all();
        // Optimasi: Gunakan select agar query lebih ringan
        $suratMasuks = SuratMasuk::select('id', 'nomor_surat_asal', 'perihal')->get();
        $suratKeluars = SuratKeluar::select('id', 'nomor_surat', 'perihal')->get();

        return view('agenda.create', compact('jenisAgendas', 'suratMasuks', 'suratKeluars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_agenda_id' => 'required|exists:jenis_agendas,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
            'tempat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'surat_masuk_id' => 'nullable|exists:surat_masuks,id',
            'surat_keluar_id' => 'nullable|exists:surat_keluars,id',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'Terjadwal'; // Default sesuai migrasi

        AgendaKegiatan::create($validated);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dijadwalkan!');
    }

    public function edit(AgendaKegiatan $agenda)
    {
        $jenisAgendas = JenisAgenda::all();
        // Disamakan optimasinya dengan create
        $suratMasuks = SuratMasuk::select('id', 'nomor_surat_asal', 'perihal')->get();
        $suratKeluars = SuratKeluar::select('id', 'nomor_surat', 'perihal')->get();
        
        return view('agenda.edit', compact('agenda', 'jenisAgendas', 'suratMasuks', 'suratKeluars'));
    }

    public function update(Request $request, AgendaKegiatan $agenda)
    {
        // Revisi Validasi: Dibuat lebih ketat sesuai store()
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_agenda_id' => 'required|exists:jenis_agendas,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
            'tempat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'surat_masuk_id' => 'nullable|exists:surat_masuks,id',
            'surat_keluar_id' => 'nullable|exists:surat_keluars,id',
            'status' => 'required|in:Terjadwal,Selesai,Batal' // Validasi enum manual
        ]);

        // created_by tidak perlu diupdate
        $agenda->update($validated);

        return redirect()->route('agenda.index')->with('success', 'Agenda diperbarui!');
    }

    public function show(AgendaKegiatan $agenda)

    {

        // Memuat relasi agar bisa ditampilkan di view (opsional, tapi disarankan)

        $agenda->load(['jenisAgenda', 'suratMasuk', 'suratKeluar', 'creator']);



        return view('agenda.show', compact('agenda'));

    }

    public function destroy(AgendaKegiatan $agenda)
    {
        $agenda->delete();
        return redirect()->route('agenda.index')->with('success', 'Agenda dihapus!');
    }
}