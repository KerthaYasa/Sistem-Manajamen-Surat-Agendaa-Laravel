<x-app-layout>
    <x-slot name="header">Data Kategori Surat</x-slot>

    {{-- Script SweetAlert (Sama persis) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
        });
    </script>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        {{-- Form Pencarian (Filter kategori dihapus karena ini adalah halaman kategori itu sendiri) --}}
        <form action="{{ route('kategori-surat.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2">
            
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="block w-full pl-10 pr-10 py-2 border border-slate-300 rounded-md text-sm placeholder-slate-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Cari kategori...">
                
                @if(request('search'))
                <a href="{{ route('kategori-surat.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-red-500" title="Reset Pencarian">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>

            <button type="submit" class="hidden">Cari</button>
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('kategori-surat.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-blue-700 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap w-10">No</th>
                        <th class="px-6 py-3 whitespace-nowrap">Nama Kategori</th>
                        <th class="px-6 py-3 min-w-[300px]">Deskripsi</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kategoris as $index => $kategori)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-3 font-medium text-slate-900 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        
                        <td class="px-6 py-3 font-medium text-slate-900 whitespace-nowrap">
                            {{ $kategori->nama_kategori }}
                        </td>

                        <td class="px-6 py-3">
                            {{ $kategori->deskripsi ?? '-' }}
                        </td>

                        <td class="px-6 py-3 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('kategori-surat.show', $kategori->id) }}" class="text-slate-500 hover:text-blue-600" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('kategori-surat.edit', $kategori->id) }}" class="text-slate-500 hover:text-orange-600" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button onclick="confirmDelete('{{ $kategori->id }}')" class="text-slate-500 hover:text-red-600" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <form id="delete-form-{{ $kategori->id }}" action="{{ route('kategori-surat.destroy', $kategori->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                            Belum ada data kategori.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination jika ada (sesuaikan controller jika pakai paginate) --}}
        {{-- @if($kategoris instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="bg-white px-6 py-3 border-t border-slate-100">
            {{ $kategoris->links() }}
        </div>
        @endif --}}
    </div>

    {{-- Script JavaScript --}}
    <script>
        // 1. Fungsi untuk Tombol Hapus Pertama (Klik icon tong sampah)
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus jenis agenda ini?',
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

        // 2. Listener saat halaman dimuat (Untuk menangkap Session dari Controller)
        document.addEventListener('DOMContentLoaded', function() {
            
            // A. Tampilkan Pesan Sukses (Jika ada)
            @if(session('success'))
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Berhasil', 
                    text: "{{ session('success') }}", 
                    timer: 2000, 
                    showConfirmButton: false 
                });
            @endif

            // B. Tampilkan Konfirmasi Hapus Paksa (Ini kode tambahannya)
            @if(session('confirm_deletion'))
                Swal.fire({
                    title: 'PERINGATAN!',
                    text: "{{ session('confirm_deletion')['message'] }}",
                    icon: 'error', // Pakai icon error/warning biar merah
                    showCancelButton: true,
                    confirmButtonColor: '#d33', // Merah
                    cancelButtonColor: '#3085d6', // Biru
                    confirmButtonText: 'Ya, Hapus Semuanya!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Membuat form rahasia secara otomatis lewat Javascript
                        let form = document.createElement('form');
                        // Ambil ID dari session yang dikirim controller
                        form.action = "{{ route('kategori-surat.destroy', session('confirm_deletion')['id']) }}";
                        form.method = 'POST';

                        // Input Token CSRF (Wajib di Laravel)
                        let csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        // Input Method DELETE
                        let methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        form.appendChild(methodField);

                        // Input Kunci: force_delete
                        let forceInput = document.createElement('input');
                        forceInput.type = 'hidden';
                        forceInput.name = 'force_delete';
                        forceInput.value = '1';
                        form.appendChild(forceInput);

                        // Tempel ke body dan kirim
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            @endif
        });
    </script>
</x-app-layout>