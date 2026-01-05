<x-app-layout>
    <x-slot name="header">Edit Jenis Agenda</x-slot>

    <div class="max-w-4xl mx-auto">
        {{-- Perhatikan parameter $jenisAgenda pada route update --}}
        <form action="{{ route('jenis-agenda.update', $jenisAgenda->id) }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="px-8 py-5 bg-white border-b border-slate-100">
                <h2 class="text-slate-800 font-bold text-xl">Edit Data Jenis Agenda</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui informasi jenis agenda di bawah ini.</p>
            </div>

            <div class="p-8 grid grid-cols-1 gap-y-6">
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Jenis Agenda</label>
                    <input type="text" name="nama_jenis" value="{{ old('nama_jenis', $jenisAgenda->nama_jenis) }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm placeholder-slate-400 text-slate-700
                        @error('nama_jenis') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        required>
                    @error('nama_jenis') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" rows="4" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('deskripsi') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror">{{ old('deskripsi', $jenisAgenda->deskripsi) }}</textarea>
                    @error('deskripsi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
                <a href="{{ route('jenis-agenda.index') }}" class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded-lg font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-500/30">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>