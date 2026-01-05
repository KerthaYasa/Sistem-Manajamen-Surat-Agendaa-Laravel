<x-app-layout>
    <x-slot name="header">Tambah Surat Masuk</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @csrf
            
            <div class="px-8 py-5 bg-white border-b border-slate-100">
                <h2 class="text-slate-800 font-bold text-xl">Formulir Surat Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Silakan lengkapi data surat masuk di bawah ini.</p>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Nomor Agenda --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Agenda</label>
                    <input type="text" name="nomor_agenda" value="{{ old('nomor_agenda') }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm placeholder-slate-400 text-slate-700" 
                        placeholder="Cth: 001/SM/2024" required>
                    @error('nomor_agenda') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Surat</label>
                    <select name="kategori_id" class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700 bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->kode_kategori }} - {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Asal Surat --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Asal Surat / Pengirim</label>
                    <input type="text" name="asal_surat" value="{{ old('asal_surat') }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" 
                        placeholder="Cth: Dinas Pendidikan Provinsi..." required>
                    @error('asal_surat') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Nomor Surat Asal --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Surat Asal</label>
                    <input type="text" name="nomor_surat_asal" value="{{ old('nomor_surat_asal') }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                {{-- Tanggal Surat --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Tertera di Surat</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                {{-- Tanggal Diterima --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Diterima (Arsip)</label>
                    <input type="date" name="tanggal_diterima" value="{{ old('tanggal_diterima', date('Y-m-d')) }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                {{-- BAGIAN BARU: Status Disposisi --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Disposisi</label>
                    <select name="status_disposisi" class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700 bg-white" required>
                        <option value="Pending" {{ old('status_disposisi') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Proses" {{ old('status_disposisi') == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ old('status_disposisi') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Selesai" {{ old('status_disposisi') == 'Selesai' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                     @error('status_disposisi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Perihal --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Perihal Surat</label>
                    <input type="text" name="perihal" value="{{ old('perihal') }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" 
                        placeholder="Pokok isi surat..." required>
                </div>

                {{-- Isi Ringkas --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ringkasan / Disposisi Awal</label>
                    <textarea name="isi_ringkas" rows="4" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" 
                        placeholder="Ringkasan singkat isi surat...">{{ old('isi_ringkas') }}</textarea>
                </div>

                {{-- Lampiran --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lampiran File (PDF/Gambar)</label>
                    <input type="file" name="lampiran_file" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-3 file:px-6
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        transition border border-slate-300 rounded-lg p-2
                    ">
                    <p class="text-xs text-slate-400 mt-2">*Maksimal ukuran file 2MB.</p>
                </div>
            </div>

            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
                <a href="{{ route('surat-masuk.index') }}" class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>