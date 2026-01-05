<x-app-layout>
    <x-slot name="header">Tambah Jenis Agenda</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('jenis-agenda.store') }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @csrf
            
            <div class="px-8 py-5 bg-white border-b border-slate-100">
                <h2 class="text-slate-800 font-bold text-xl">Jenis Agenda Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Silakan isi nama dan deskripsi jenis agenda.</p>
            </div>

            <div class="p-8 grid grid-cols-1 gap-y-6">
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Jenis Agenda</label>
                    <input type="text" name="nama_jenis" value="{{ old('nama_jenis') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm placeholder-slate-400 text-slate-700
                        @error('nama_jenis') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Cth: Rapat Internal, Kunjungan Lapangan" required>
                    @error('nama_jenis') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" rows="4" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('deskripsi') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Penjelasan singkat mengenai jenis agenda ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
                <a href="{{ route('jenis-agenda.index') }}" class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>