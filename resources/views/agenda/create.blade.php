<x-app-layout>
    <x-slot name="header">Tambah Agenda Kegiatan</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('agenda.store') }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @csrf
            
            <div class="px-8 py-5 bg-white border-b border-slate-100">
                <h2 class="text-slate-800 font-bold text-xl">Formulir Agenda Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Silakan lengkapi detail kegiatan di bawah ini.</p>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm placeholder-slate-400 text-slate-700
                        @error('nama_kegiatan') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Cth: Rapat Evaluasi Bulanan..." required>
                    @error('nama_kegiatan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Agenda</label>
                    <select name="jenis_agenda_id" class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700 bg-white
                        @error('jenis_agenda_id') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($jenisAgendas as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenis_agenda_id') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_agenda_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700 bg-white
                        @error('status') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror">
                        <option value="Terjadwal" {{ old('status') == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Waktu Mulai</label>
                    <input type="datetime-local" name="waktu_mulai" value="{{ old('waktu_mulai') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('waktu_mulai') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" required>
                    @error('waktu_mulai') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Waktu Selesai</label>
                    <input type="datetime-local" name="waktu_selesai" value="{{ old('waktu_selesai') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('waktu_selesai') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" required>
                    @error('waktu_selesai') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Kegiatan</label>
                    <input type="text" name="tempat" value="{{ old('tempat') }}" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('tempat') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Cth: Aula Utama Lt. 2" required>
                    @error('tempat') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" 
                        class="w-full rounded-lg py-3 px-4 shadow-sm text-slate-700
                        @error('keterangan') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-slate-300 focus:ring-blue-500 focus:border-blue-500 @enderror" 
                        placeholder="Tambahan informasi...">{{ old('keterangan') }}</textarea>
                </div>

                <div class="md:col-span-2 border-t border-slate-100 pt-4 mt-2">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Relasi Surat (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase">Surat Masuk Terkait</label>
                            <select name="surat_masuk_id" class="w-full rounded-lg py-2 px-3 text-sm shadow-sm text-slate-700 border-slate-300 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="">-- Tidak Ada --</option>
                                @foreach($suratMasuks as $sm)
                                    <option value="{{ $sm->id }}" {{ old('surat_masuk_id') == $sm->id ? 'selected' : '' }}>
                                        {{ $sm->nomor_surat }} - {{ Str::limit($sm->perihal, 30) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase">Surat Keluar Terkait</label>
                            <select name="surat_keluar_id" class="w-full rounded-lg py-2 px-3 text-sm shadow-sm text-slate-700 border-slate-300 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="">-- Tidak Ada --</option>
                                @foreach($suratKeluars as $sk)
                                    <option value="{{ $sk->id }}" {{ old('surat_keluar_id') == $sk->id ? 'selected' : '' }}>
                                        {{ $sk->nomor_surat }} - {{ Str::limit($sk->perihal, 30) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-4">
                <a href="{{ route('agenda.index') }}" class="px-6 py-3 text-slate-700 bg-white border border-slate-300 rounded-lg font-medium hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                    Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</x-app-layout>