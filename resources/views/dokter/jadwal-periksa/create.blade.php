<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Jadwal Periksa') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
      <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
        <div class="max-w-xl">
          <section>
            <header>
              <h2 class="text-lg font-medium text-gray-900">
                {{ __('Tambah Jadwal Periksa') }}
              </h2>
              <p class="mt-1 text-sm text-gray-600">
                {{ __('Silakan isi form di bawah ini untuk menambahkan jadwal pemeriksaan dokter sesuai dengan hari dan waktu yang tersedia.') }}
              </p>
            </header>

            <form class="mt-6" id="formJadwalPeriksa" action="{{ route('dokter.jadwal-periksa.store') }}"
              method="POST">
              @csrf

              <div class="mb-3 form-group">
                <label for="hari">Hari</label>
                <select class="rounded form-control" id="hari" name="hari">
                  <option value="" disabled selected>Pilih Hari</option>
                  @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    <option value="{{ $day }}" {{ old('hari') === $day ? 'selected' : '' }}>
                      {{ $day }}
                    </option>
                  @endforeach
                </select>
                <x-input-error :messages="$errors->get('hari')" class="mt-2" />
              </div>

              <div class="mb-3 form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" class="rounded form-control" id="jam_mulai" name="jam_mulai"
                  value="{{ old('jam_mulai') }}">
                <x-input-error :messages="$errors->get('jam_mulai')" class="mt-2" />
              </div>

              <div class="mb-3 form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" class="rounded form-control" id="jam_selesai" name="jam_selesai"
                  value="{{ old('jam_selesai') }}">
                <x-input-error :messages="$errors->get('jam_selesai')" class="mt-2" />
              </div>

              <div class="flex items-center gap-4 mt-4">
                <a href="{{ route('dokter.jadwal-periksa.index') }}" class="btn btn-secondary">
                  Batal
                </a>
                <button type="submit" class="btn btn-primary">
                  Simpan
                </button>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
