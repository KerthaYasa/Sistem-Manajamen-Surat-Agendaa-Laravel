<x-app-layout>
    <x-slot name="header">Detail Surat Masuk</x-slot>

    <div class="max-w-6xl mx-auto space-y-6">
        
        {{-- Header Card --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide 
                        {{ $suratMasuk->status_disposisi == 'Pending' ? 'bg-orange-100 text-orange-700' : 
                           ($suratMasuk->status_disposisi == 'Proses' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                        {{ $suratMasuk->status_disposisi }}
                    </span>
                    <span class="text-slate-400 text-sm">|</span>
                    <span class="text-slate-500 text-sm font-medium">No. Agenda: <span class="text-slate-900">{{ $suratMasuk->nomor_agenda }}</span></span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 leading-tight">{{ $suratMasuk->asal_surat }}</h1>
                <p class="text-slate-500 mt-1">Perihal: {{ $suratMasuk->perihal }}</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('surat-masuk.edit', $suratMasuk->id) }}" class="inline-flex items-center px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg font-medium text-sm text-orange-700 hover:bg-orange-100 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Data
                </a>
                <a href="{{ route('surat-masuk.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-slate-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Kolom Kiri: Informasi Rinci --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="font-semibold text-slate-800">Informasi Rinci</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                            
                            {{-- Data Kategori, Nomor, Tanggal (Biarkan seperti sebelumnya) --}}
                            <div class="col-span-1">
                                <dt class="text-xs font-medium text-slate-500 uppercase">Kategori Surat</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $suratMasuk->kategori->nama_kategori ?? '-' }}</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-xs font-medium text-slate-500 uppercase">Nomor Surat Asal</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ $suratMasuk->nomor_surat_asal }}</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-xs font-medium text-slate-500 uppercase">Tanggal Surat</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ date('d F Y', strtotime($suratMasuk->tanggal_surat)) }}</dd>
                            </div>
                            <div class="col-span-1">
                                <dt class="text-xs font-medium text-slate-500 uppercase">Tanggal Diterima</dt>
                                <dd class="mt-1 text-sm text-slate-900">{{ date('d F Y', strtotime($suratMasuk->tanggal_diterima)) }}</dd>
                            </div>
                            
                            {{-- PERBAIKAN DI SINI (Gunakan ->creator) --}}
                            <div class="col-span-1 border-t border-slate-100 pt-4 md:border-none md:pt-0">
                                <dt class="text-xs font-medium text-slate-500 uppercase">Dibuat Oleh</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-medium">
                                    {{-- Menggunakan creator->name --}}
                                    {{ $suratMasuk->creator->name ?? 'System / Admin' }}
                                </dd>
                            </div>

                            <div class="col-span-1 border-t border-slate-100 pt-4 md:border-none md:pt-0">
                                <dt class="text-xs font-medium text-slate-500 uppercase">Dibuat Pada</dt>
                                <dd class="mt-1 text-sm text-slate-900">
                                    {{ $suratMasuk->created_at->format('d F Y H:i') }}
                                </dd>
                            </div>

                            <div class="col-span-1">
                                <dt class="text-xs font-medium text-slate-500 uppercase">Terakhir Diupdate</dt>
                                <dd class="mt-1 text-sm text-slate-900">
                                    {{ $suratMasuk->updated_at->format('d F Y H:i') }}
                                </dd>
                            </div>

                            <div class="col-span-1 md:col-span-2 mt-2">
                                <dt class="text-xs font-medium text-slate-500 uppercase mb-2">Isi Ringkas / Disposisi Awal</dt>
                                <dd class="text-sm text-slate-900 bg-slate-50 p-4 rounded-lg border border-slate-100 leading-relaxed">
                                    {{ $suratMasuk->isi_ringkas ?: 'Tidak ada ringkasan.' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: File Lampiran --}}
            <div class="lg:col-span-1">
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden h-full">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="font-semibold text-slate-800">File Lampiran</h3>
                    </div>
                    <div class="p-6 flex flex-col items-center justify-center text-center h-64">
                        @if($suratMasuk->lampiran_file)
                            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-slate-900 mb-1 truncate w-full px-4">
                                {{ Str::afterLast($suratMasuk->lampiran_file, '/') }}
                            </p>
                            <p class="text-xs text-slate-500 mb-4">Klik tombol di bawah untuk melihat file.</p>
                            
                            <a href="{{ asset('storage/' . $suratMasuk->lampiran_file) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat / Download
                            </a>
                        @else
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            </div>
                            <p class="text-sm text-slate-500">Tidak ada file lampiran.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>