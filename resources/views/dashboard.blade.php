<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Surat Masuk</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $countMasuk ?? \App\Models\SuratMasuk::count() }}</h3>
                            <p class="text-xs text-blue-600 font-medium mt-2 bg-blue-50 inline-block px-2 py-1 rounded">Dokumen Aktif</p>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Surat Keluar</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\SuratKeluar::count() }}</h3>
                            <p class="text-xs text-purple-600 font-medium mt-2 bg-purple-50 inline-block px-2 py-1 rounded">Total Terkirim</p>
                        </div>
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Agenda</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\AgendaKegiatan::count() }}</h3>
                            <p class="text-xs text-orange-600 font-medium mt-2 bg-orange-50 inline-block px-2 py-1 rounded">Jadwal Mendatang</p>
                        </div>
                        <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">Aktivitas Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-1">5 surat masuk terakhir yang diterima sistem</p>
                    </div>
                    <a href="{{ route('surat-masuk.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                        Lihat Semua 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-xs uppercase text-slate-500 font-bold border-b border-slate-200">
                                <th class="px-6 py-4 whitespace-nowrap w-1/12">No. Agenda</th>
                                <th class="px-6 py-4 whitespace-nowrap w-1/12">Tgl. Diterima</th>
                                <th class="px-6 py-4 whitespace-nowrap">Kategori</th>
                                <th class="px-6 py-4 whitespace-nowrap w-3/12">Asal Surat</th>
                                <th class="px-6 py-4 whitespace-nowrap w-3/12">Perihal</th>
                                <th class="px-6 py-4 whitespace-nowrap w-1/12">Status</th>
                                <th class="px-6 py-4 whitespace-nowrap w-1/12 text-center">File</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($recents as $surat)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4 text-sm font-bold text-slate-700 align-top">
                                    {{ $surat->nomor_agenda }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600 align-top">
                                    {{ date('d/m/Y', strtotime($surat->tanggal_diterima)) }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600 align-top whitespace-nowrap">
                                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded text-xs font-semibold border border-slate-200">
                                        {{ $surat->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="text-sm font-bold text-slate-800">{{ $surat->asal_surat }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">No: {{ $surat->nomor_surat_asal }}</div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate align-top">
                                    {{ $surat->perihal }}
                                </td>

                                <td class="px-6 py-4 align-top whitespace-nowrap">
                                    @if($surat->status_disposisi == 'Selesai')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                            SELESAI
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-600"></span>
                                            PENDING
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center align-top">
                                    @if($surat->lampiran_file)
                                        <a href="{{ asset('storage/' . $surat->lampiran_file) }}" target="_blank" class="inline-block text-blue-600 hover:text-blue-800 transition" title="Download File">
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </a>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        <p>Belum ada aktivitas surat masuk.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>