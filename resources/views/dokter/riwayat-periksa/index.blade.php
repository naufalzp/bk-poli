<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Riwayat Janji Periksa') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
      <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
        <section>
          @if ($jadwalPeriksa)
            <header class="flex items-center justify-between">
              <h2 class="text-lg font-medium text-gray-900">
                {{ __('Daftar Riwayat Janji Periksa - ') }}{{ $jadwalPeriksa->full_jadwal }}
              </h2>

              @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 rounded px-4 py-2">
                  {{ session('success') }}
                </div>
              @endif
            </header>
          @endif

          @if (!$jadwalPeriksa)
            <div class="text-center py-12">
              <i class="fas fa-calendar-times text-gray-400 text-6xl mb-4"></i>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Jadwal Periksa</h3>
              <p class="text-gray-600">Anda belum memiliki jadwal periksa yang aktif. Silakan tambah atau aktifkan
                jadwal periksa anda.
              </p>
            </div>
          @else
            <div class="overflow-x-auto mt-6 rounded">
              <table class="table min-w-full table-hover">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal Periksa</th>
                    <th scope="col">No. RM</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Keluhan</th>
                    <th scope="col">Biaya</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($periksas as $periksa)
                    <tr>
                      <th scope="row" class="align-middle text-start">
                        {{ $loop->iteration }}
                      </th>
                      <td class="align-middle text-start">
                        {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('Y-m-d') }}
                      </td>
                      <td class="align-middle text-start">
                        {{ $periksa->janjiPeriksa->pasien->no_rm }}
                      </td>
                      <td class="align-middle text-start">
                        {{ $periksa->janjiPeriksa->pasien->nama }}
                      </td>
                      <td class="align-middle text-start">
                        {{ $periksa->janjiPeriksa->keluhan }}
                      </td>
                      <td class="align-middle text-start">
                        Rp {{ number_format($periksa->biaya_periksa, 2, ',', '.') }}
                      </td>
                      <td class="flex items-center gap-3">
                        <a href="{{ route('dokter.riwayat-periksa.edit', $periksa->id) }}"
                          class="btn btn-warning btn-sm" title="Edit Riwayat">
                          <i class="fas fa-edit"></i>
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="align-middle text-center">
                        <div class="py-8">
                          <i class="fas fa-history text-gray-400 text-6xl mb-4"></i>
                          <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Periksa</h3>
                          <p class="text-gray-600">Anda belum melakukan pemeriksaan pada jadwal ini.</p>
                        </div>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
              <div>
                {{ $periksas->links() }}
              </div>
            </div>
          @endif
        </section>
      </div>
    </div>
  </div>
</x-app-layout>
