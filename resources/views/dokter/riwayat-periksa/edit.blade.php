<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Edit Riwayat Periksa') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
      <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="col-span-1">
            <header class="mb-4">
              <h2 class="text-lg font-medium text-gray-900">
                {{ __('Detail Pasien') }}
              </h2>
              <p class="text-sm text-gray-600">Informasi pasien dan keluhan</p>
            </header>

            <div class="form-group">
              <label for="no_rm">Nomor Rekam Medis</label>
              <input type="text" class="rounded form-control" id="no_rm"
                value="{{ $periksa->janjiPeriksa->pasien->no_rm }}" name="no_rm" readonly>
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="rounded form-control" id="nama"
                value="{{ $periksa->janjiPeriksa->pasien->nama }}" name="nama" readonly>
            </div>
            <div class="form-group">
              <label for="keluhan">Keluhan</label>
              <textarea class="form-control" id="keluhan" name="keluhan" rows="3" readonly>{{ $periksa->janjiPeriksa->keluhan }}</textarea>
            </div>
            
            @if($periksa->obats->count() > 0)
              <div class="form-group">
                <label>Obat yang Dipilih Sebelumnya</label>
                <div class="p-3 bg-gray-50 rounded">
                  @foreach($periksa->obats as $obat)
                    <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded mr-1 mb-1">
                      {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                    </span>
                  @endforeach
                </div>
              </div>
            @endif
          </div>
          <div class="col-span-1">
            <header class="mb-4">
              <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit Hasil Periksa') }}
              </h2>
              <p class="text-sm text-gray-600">Ubah hasil pemeriksaan dan obat yang diberikan</p>
            </header>

            <form action="{{ route('dokter.riwayat-periksa.update', $periksa->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="tgl_periksa">Tanggal Periksa</label>
                <input type="date" class="rounded form-control" id="tgl_periksa" name="tgl_periksa"
                  value="{{ $periksa->tgl_periksa }}" required>
                @error('tgl_periksa')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control" id="catatan" name="catatan" rows="3" required>{{ $periksa->catatan }}</textarea>
                @error('catatan')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="obat">Obat</label>
                <select class="form-control" id="obat" name="obat[]" required multiple>
                  @foreach ($obats as $obat)
                    <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}" 
                      {{ $periksa->obats->contains('id', $obat->id) ? 'selected' : '' }}>
                      {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                    </option>
                  @endforeach
                </select>
                @error('obat')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="biaya_periksa">Biaya Periksa</label>
                <input type="text" class="rounded form-control" id="biaya_periksa" value="{{ $periksa->biaya_periksa }}"
                  name="biaya_periksa" readonly>
                @error('biaya_periksa')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex items-center gap-4">
                <button type="submit" class="btn btn-primary">
                  Update
                </button>
                <a href="{{ route('dokter.riwayat-periksa.index') }}" class="btn btn-secondary">
                  Back
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const obatSelect = document.getElementById('obat');
      const biayaInput = document.getElementById('biaya_periksa');
      const biayaAwal = 150000;

      function updateBiaya() {
        let total = biayaAwal;
        Array.from(obatSelect.selectedOptions).forEach(option => {
          const harga = parseInt(option.getAttribute('data-harga')) || 0;
          total += harga;
        });
        biayaInput.value = total;
      }

      // Hitung biaya awal saat halaman dimuat
      updateBiaya();
      
      // Update biaya saat pilihan obat berubah
      obatSelect.addEventListener('change', updateBiaya);
    });
  </script>
</x-app-layout>
