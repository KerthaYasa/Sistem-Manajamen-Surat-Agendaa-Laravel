<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Detail Agenda') }}
            </h2>
            <div class="text-sm text-slate-500">
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- BAGIAN 1: HEADER CARD (Judul & Tombol) --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                
                {{-- Kiri: Judul & Status --}}
                <div class="space-y-2">
                    <div class="flex items-center gap-3 text-sm">
                        {{-- Status Badge --}}
                        @php
                            $statusClass = match($agenda->status) {
                                'Terjadwal' => 'bg-blue-100 text-blue-700',
                                'Selesai'   => 'bg-green-100 text-green-700',
                                'Batal'     => 'bg-red-100 text-red-700',
                                default     => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-md text-xs font-bold uppercase tracking-wide {{ $statusClass }}">
                            {{ $agenda->status }}
                        </span>
                        
                        <span class="text-slate-300">|</span>
                        <span class="text-slate-500 font-medium">ID: #{{ $agenda->id }}</span>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
                        {{ $agenda->nama_kegiatan }}
                    </h1>
                </div>

                {{-- Kanan: Tombol Action --}}
                <div class="flex items-center gap-3 mt-2 md:mt-0">
                    <a href="{{ route('agenda.edit', $agenda->id) }}" class="inline-flex items-center px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg text-sm font-medium text-orange-700 hover:bg-orange-100 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Data
                    </a>
                    <a href="{{ route('agenda.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-700 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-slate-800 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- BAGIAN 2: GRID CONTENT --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: Informasi Rinci (Lebar 2/3) --}}
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm flex flex-col h-full">
                
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800">Informasi Rinci</h3>
                </div>

                <div class="p-6 flex-1">
                    {{-- Grid Data (Layout Sebelumnya) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8 mb-8">
                        
                        {{-- Jenis Agenda --}}
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Agenda</span>
                            <span class="block text-sm text-slate-800">{{ $agenda->jenisAgenda->nama_jenis }}</span>
                        </div>

                        {{-- Tempat --}}
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tempat Pelaksanaan</span>
                            <span class="block text-sm text-slate-800">{{ $agenda->tempat }}</span>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Waktu Mulai</span>
                            <span class="block text-sm text-slate-800">
                                {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->translatedFormat('d F Y, H:i') }}
                            </span>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Waktu Selesai</span>
                            <span class="block text-sm text-slate-800">
                                {{ \Carbon\Carbon::parse($agenda->waktu_selesai)->translatedFormat('d F Y, H:i') }}
                            </span>
                        </div>

                        {{-- Dibuat Oleh --}}
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dibuat Oleh</span>
                            <span class="block text-sm text-slate-800">{{ $agenda->creator->name ?? 'System' }}</span>
                        </div>

                        {{-- Tanggal Dibuat --}}
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dibuat Pada</span>
                            <span class="block text-sm text-slate-800">
                                {{ $agenda->created_at->translatedFormat('d F Y H:i') }}
                            </span>
                        </div>

                         {{-- Terakhir Diupdate --}}
                         <div class="md:col-span-2">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Terakhir Diupdate</span>
                            <span class="block text-sm text-slate-800">
                                {{ $agenda->updated_at->translatedFormat('d F Y H:i') }}
                            </span>
                        </div>
                    </div>

                    {{-- Box Keterangan (Isi Ringkas) --}}
                    <div class="col-span-1 md:col-span-2 mt-2">
                        <dt class="text-xs font-medium text-slate-500 uppercase mb-2">Isi Ringkas</dt>
                             <dd class="text-sm text-slate-900 bg-slate-50 p-4 rounded-lg border border-slate-100 leading-relaxed">
                                {{ $agenda->keterangan ?: 'Tidak ada keterangan tambahan.' }}
                            </dd>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Referensi Surat (Lebar 1/3) --}}
            <div class="lg:col-span-1 bg-white border border-slate-200 rounded-xl shadow-sm flex flex-col h-full">
                
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="text-base font-bold text-slate-800">Referensi Surat</h3>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    
                    {{-- Cek Surat Masuk --}}
                    @if($agenda->suratMasuk)
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Surat Masuk</span>
                            </div>
                            <p class="text-xs text-slate-400 uppercase font-bold mb-1">Nomor Surat</p>
                            <p class="text-sm font-medium text-slate-800 mb-4">{{ $agenda->suratMasuk->nomor_surat_asal }}</p>
                            
                            {{-- Tombol Lihat Surat Masuk --}}
                            {{-- Pastikan route 'surat-masuk.show' ada --}}
                            <a href="{{ route('surat-masuk.show', $agenda->suratMasuk->id) }}" class="block w-full text-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                                Lihat Detail Surat
                            </a>
                        </div>
                        <hr class="border-slate-100 mb-6">
                    @endif

                    {{-- Cek Surat Keluar --}}
                    @if($agenda->suratKeluar)
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Surat Keluar</span>
                            </div>
                            <p class="text-xs text-slate-400 uppercase font-bold mb-1">Nomor Surat</p>
                            <p class="text-sm font-medium text-slate-800 mb-4">{{ $agenda->suratKeluar->nomor_surat }}</p>

                            {{-- Tombol Lihat Surat Keluar --}}
                             {{-- Pastikan route 'surat-keluar.show' ada --}}
                            <a href="{{ route('surat-keluar.show', $agenda->suratKeluar->id) }}" class="block w-full text-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                                Lihat Detail Surat
                            </a>
                        </div>
                    @endif

                    {{-- Jika Tidak Ada Surat --}}
                    @if(!$agenda->suratMasuk && !$agenda->suratKeluar)
                        <div class="flex flex-col items-center justify-center h-full py-8 text-center opacity-60">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-sm text-slate-500">Agenda ini tidak terlampir pada surat manapun.</p>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
</x-app-layout>