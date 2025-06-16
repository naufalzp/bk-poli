<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Periksa') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
      <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="col-span-1">
            <header class="mb-2">
              <h2 class="text-lg font-medium text-gray-900">
                {{ __('Detail Janji') }}
              </h2>
            </header>

            <div class="form-group">
              <label for="no_rm">Nomor Rekam Medis</label>
              <input type="text" class="rounded form-control" id="no_rm"
                value="{{ $janjiPeriksa->pasien->no_rm }}" name="no_rm" readonly>
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="rounded form-control" id="nama"
                value="{{ $janjiPeriksa->pasien->nama }}" name="nama" readonly>
            </div>
            <div class="form-group">
              <label for="keluhan">Keluhan</label>
              <textarea class="form-control" id="keluhan" name="keluhan" rows="3" readonly>{{ $janjiPeriksa->keluhan }}</textarea>
            </div>
          </div>
          <div class="col-span-1">
            <header class="mb-2">
              <h2 class="text-lg font-medium text-gray-900">
                {{ __('Form Periksa') }}
              </h2>
            </header>

            <form action="{{ route('dokter.janji-periksa.store', $janjiPeriksa->id) }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="tgl_periksa">Tanggal Periksa</label>
                <input type="date" class="rounded form-control" id="tgl_periksa" name="tgl_periksa"
                  value="{{ old('tgl_periksa', now()->format('Y-m-d')) }}" required>
                @error('tgl_periksa')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control" id="catatan" name="catatan" rows="3" required>{{ old('catatan') }}</textarea>
                @error('catatan')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="obat">Obat</label>
                <select class="form-control" id="obat" name="obat[]" required multiple>
                  @foreach ($obats as $obat)
                    <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}">{{ $obat->nama_obat }} - Rp
                      {{ $obat->harga }}</option>
                  @endforeach
                </select>
                @error('obat')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="biaya_periksa">Biaya Periksa</label>
                <input type="text" class="rounded form-control" id="biaya_periksa" value="150000"
                  name="biaya_periksa" readonly>
                @error('biaya_periksa')
                  <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex items-center gap-4">
                <button type="submit" class="btn btn-primary">Submit</button>
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

      obatSelect.addEventListener('change', updateBiaya);
    });
  </script>
</x-app-layout>
