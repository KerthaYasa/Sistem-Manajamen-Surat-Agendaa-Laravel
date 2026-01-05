<x-app-layout>
    <x-slot name="header">Edit Kategori</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('kategori-surat.update', $kategoriSurat->id) }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="px-8 py-5 bg-white border-b border-slate-100">
                <h2 class="text-slate-800 font-bold text-xl">Edit Data Kategori</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui informasi kategori di bawah ini.</p>
            </div>

            <div class="p-8 grid grid-cols-1 gap-y-6">
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategoriSurat->nama_kategori) }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm placeholder-slate-400 text-slate-700
                        @error('nama_kategori') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        required>
                    @error('nama_kategori') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" rows="4" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('deskripsi') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror">{{ old('deskripsi', $kategoriSurat->deskripsi) }}</textarea>
                    @error('deskripsi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
                <a href="{{ route('kategori-surat.index') }}" class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded-lg font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-500/30">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>