<x-app-layout>
    <x-slot name="header">Edit Surat Masuk</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('surat-masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="px-8 py-5 bg-white border-b border-slate-100">
                <h2 class="text-slate-800 font-bold text-xl">Edit Data Surat</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui informasi surat masuk di bawah ini.</p>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Agenda</label>
                    <input type="text" name="nomor_agenda" value="{{ old('nomor_agenda', $suratMasuk->nomor_agenda) }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Surat</label>
                    <select name="kategori_id" class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700 bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $suratMasuk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->kode_kategori }} - {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Asal Surat / Pengirim</label>
                    <input type="text" name="asal_surat" value="{{ old('asal_surat', $suratMasuk->asal_surat) }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Surat Asal</label>
                    <input type="text" name="nomor_surat_asal" value="{{ old('nomor_surat_asal', $suratMasuk->nomor_surat_asal) }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Tertera di Surat</label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat) }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Diterima (Arsip)</label>
                    <input type="date" name="tanggal_diterima" value="{{ old('tanggal_diterima', $suratMasuk->tanggal_diterima) }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Surat</label>
                    <select name="status_disposisi" class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700 bg-white">
                        <option value="Pending" {{ $suratMasuk->status_disposisi == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Proses" {{ $suratMasuk->status_disposisi == 'Proses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ $suratMasuk->status_disposisi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Arsip" {{ $suratMasuk->status_disposisi == 'Arsip' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Perihal Surat</label>
                    <input type="text" name="perihal" value="{{ old('perihal', $suratMasuk->perihal) }}" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ringkasan / Disposisi Awal</label>
                    <textarea name="isi_ringkas" rows="4" 
                        class="w-full rounded-lg border-slate-300 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 shadow-sm text-slate-700">{{ old('isi_ringkas', $suratMasuk->isi_ringkas) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Update Lampiran (Opsional)</label>
                    <input type="file" name="lampiran_file" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-3 file:px-6
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        transition border border-slate-300 rounded-lg p-2
                    ">
                    @if($suratMasuk->lampiran_file)
                        <div class="mt-2 text-sm text-slate-600 flex items-center">
                            <span class="font-semibold mr-2">File saat ini:</span>
                            <a href="{{ asset('storage/'.$suratMasuk->lampiran_file) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
                <a href="{{ route('surat-masuk.index') }}" class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded-lg font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-500/30">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>