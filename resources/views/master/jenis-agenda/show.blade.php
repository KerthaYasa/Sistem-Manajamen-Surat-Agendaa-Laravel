<x-app-layout>
    <x-slot name="header">Detail Jenis Agenda</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Header Card --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide bg-blue-100 text-blue-700">
                        Aktif
                    </span>
                    <span class="text-slate-400 text-sm">|</span>
                    <span class="text-slate-500 text-sm font-medium">ID Jenis: <span class="text-slate-900">#{{ $jenisAgenda->id }}</span></span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 leading-tight">{{ $jenisAgenda->nama_jenis }}</h1>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('jenis-agenda.edit', $jenisAgenda->id) }}" class="inline-flex items-center px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg font-medium text-sm text-orange-700 hover:bg-orange-100 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Data
                </a>
                <a href="{{ route('jenis-agenda.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-slate-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        {{-- Kolom Informasi --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-semibold text-slate-800">Informasi Rinci</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    
                    <div class="col-span-1 md:col-span-2">
                        <dt class="text-xs font-medium text-slate-500 uppercase">Nama Jenis Agenda</dt>
                        <dd class="mt-1 text-lg font-medium text-slate-900">{{ $jenisAgenda->nama_jenis }}</dd>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <dt class="text-xs font-medium text-slate-500 uppercase">Deskripsi</dt>
                        <dd class="mt-1 text-sm text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-100">
                            {{ $jenisAgenda->deskripsi ?: 'Tidak ada deskripsi.' }}
                        </dd>
                    </div>

                    <div class="col-span-1">
                        <dt class="text-xs font-medium text-slate-500 uppercase">Dibuat Pada</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $jenisAgenda->created_at->format('d F Y, H:i') }}</dd>
                    </div>
                    
                    <div class="col-span-1">
                        <dt class="text-xs font-medium text-slate-500 uppercase">Terakhir Diupdate</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $jenisAgenda->updated_at->format('d F Y, H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</x-app-layout>