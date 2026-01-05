<x-app-layout>
    <x-slot name="header">Tambah Surat Keluar</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @csrf
            
            <div class="px-8 py-5 bg-white border-b border-slate-100">
                <h2 class="text-slate-800 font-bold text-xl">Formulir Surat Keluar Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Silakan lengkapi data surat keluar di bawah ini.</p>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Agenda</label>
                    <input type="text" name="nomor_agenda" value="{{ old('nomor_agenda') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm placeholder-slate-400 text-slate-700
                        @error('nomor_agenda') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Cth: 001/SK/2024" required>
                    @error('nomor_agenda') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Surat</label>
                    <select name="kategori_id" class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700 bg-white
                        @error('kategori_id') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->kode_kategori }} - {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tujuan Surat</label>
                    <input type="text" name="tujuan_surat" value="{{ old('tujuan_surat') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('tujuan_surat') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Cth: Kepada Yth. Kepala Dinas..." required>
                    @error('tujuan_surat') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Surat</label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('nomor_surat') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" required>
                    @error('nomor_surat') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('tanggal_surat') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" required>
                    @error('tanggal_surat') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Surat</label>
                    <select name="status" class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700 bg-white
                        @error('status') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror">
                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Dikirim" {{ old('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="Diarsipkan" {{ old('status') == 'Diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Perihal Surat</label>
                    <input type="text" name="perihal" value="{{ old('perihal') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('perihal') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Pokok isi surat..." required>
                    @error('perihal') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ringkasan Isi</label>
                    <textarea name="isi_ringkas" rows="4" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('isi_ringkas') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Ringkasan singkat isi surat...">{{ old('isi_ringkas') }}</textarea>
                    @error('isi_ringkas') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lampiran File (PDF/Gambar)</label>
                    <input type="file" name="lampiran_file" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-3 file:px-6
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        transition border rounded-lg p-2
                        @error('lampiran_file') border-red-500 text-red-500 @else border-slate-300 @enderror
                    ">
                    <p class="text-xs text-slate-400 mt-2">*Maksimal ukuran file 2MB.</p>
                    @error('lampiran_file') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
                <a href="{{ route('surat-keluar.index') }}" class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>