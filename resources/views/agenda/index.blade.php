<x-app-layout>
    <x-slot name="header">Agenda Kegiatan</x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
        });
    </script>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        {{-- Form Pencarian & Filter --}}
        <form action="{{ route('agenda.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2">
            
            <div class="relative">
                <select name="jenis_agenda_id" onchange="this.form.submit()" class="block w-full md:w-48 pl-3 pr-8 py-2 border border-slate-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-slate-600">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisAgendas as $jenis)
                        <option value="{{ $jenis->id }}" {{ request('jenis_agenda_id') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="block w-full md:w-40 pl-3 pr-8 py-2 border border-slate-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-slate-600">
                    <option value="">Semua Status</option>
                    <option value="Terjadwal" {{ request('status') == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="block w-full pl-10 pr-10 py-2 border border-slate-300 rounded-md text-sm placeholder-slate-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Cari agenda...">
                
                @if(request('search') || request('jenis_agenda_id') || request('status'))
                <a href="{{ route('agenda.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500" title="Reset Pencarian">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('agenda.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Agenda
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap">Waktu Pelaksanaan</th>
                        <th class="px-6 py-3 min-w-[200px]">Nama Kegiatan</th>
                        <th class="px-6 py-3 whitespace-nowrap">Tempat</th>
                        <th class="px-6 py-3 whitespace-nowrap">Status</th>
                        <th class="px-6 py-3 whitespace-nowrap text-center">Relasi Surat</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($agendas as $agenda)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-800">
                                {{ date('d M Y', strtotime($agenda->waktu_mulai)) }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ date('H:i', strtotime($agenda->waktu_mulai)) }} - {{ date('H:i', strtotime($agenda->waktu_selesai)) }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-3">
                            <div class="font-semibold text-slate-900">{{ $agenda->nama_kegiatan }}</div>
                            <div class="text-xs text-slate-500 mt-0.5 inline-flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                {{ $agenda->jenisAgenda->nama_jenis ?? '-' }}
                            </div>
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ Str::limit($agenda->tempat, 20) }}
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap">
                            @if($agenda->status == 'Terjadwal')
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-semibold">Terjadwal</span>
                            @elseif($agenda->status == 'Selesai')
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-semibold">Selesai</span>
                            @elseif($agenda->status == 'Batal')
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-semibold">Batal</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-semibold">{{ $agenda->status }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-3 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                @if($agenda->surat_masuk_id)
                                    <span class="bg-purple-50 text-purple-600 border border-purple-200 text-[10px] font-bold px-1.5 py-0.5 rounded" title="Terkait Surat Masuk">SM</span>
                                @endif
                                @if($agenda->surat_keluar_id)
                                    <span class="bg-orange-50 text-orange-600 border border-orange-200 text-[10px] font-bold px-1.5 py-0.5 rounded" title="Terkait Surat Keluar">SK</span>
                                @endif
                                @if(!$agenda->surat_masuk_id && !$agenda->surat_keluar_id)
                                    <span class="text-slate-300">-</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-3 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('agenda.show', $agenda->id) }}" class="text-slate-500 hover:text-blue-600" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('agenda.edit', $agenda->id) }}" class="text-slate-500 hover:text-orange-600" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button onclick="confirmDelete('{{ $agenda->id }}')" class="text-slate-500 hover:text-red-600" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <form id="delete-form-{{ $agenda->id }}" action="{{ route('agenda.destroy', $agenda->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                            Belum ada data agenda kegiatan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($agendas->hasPages())
        <div class="bg-white px-6 py-3 border-t border-slate-100">
            {{ $agendas->links() }}
        </div>
        @endif
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus agenda ini?',
                text: "Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>