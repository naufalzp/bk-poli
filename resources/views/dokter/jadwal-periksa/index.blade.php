<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Jadwal Periksa') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
      <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
        <section>
          <header class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">
              {{ __('Daftar Jadwal Periksa') }}
            </h2>
            <div class="flex-col items-center justify-center text-center">
              <a href="{{ route('dokter.jadwal-periksa.create') }}" class="btn btn-primary">Tambah Jadwal</a>

              @if (session('status') === 'jadwal-periksa-created')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                  class="text-sm text-gray-600 ">
                  {{ __('Created.') }}
                </p>
              @endif
            </div>
          </header>

          <div class="overflow-x-auto mt-6 rounded">
            <table class="table min-w-full table-hover">
              <thead class="thead-light">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Hari</th>
                  <th scope="col">Mulai</th>
                  <th scope="col">Selesai</th>
                  <th scope="col">Status</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($jadwalPeriksas as $jadwalPeriksa)
                  <tr>
                    <th scope="row" class="align-middle text-start">
                      {{ $loop->iteration }}
                    </th>
                    <td class="align-middle text-start">
                      {{ $jadwalPeriksa->hari }}
                    </td>
                    <td class="align-middle text-start">
                      {{ $jadwalPeriksa->jam_mulai }}
                    </td>
                    <td class="align-middle text-start">
                      {{ $jadwalPeriksa->jam_selesai }}
                    </td>
                    <td class="align-middle text-start">
                      @if ($jadwalPeriksa->status == true)
                        <span
                          class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                          Aktif
                        </span>
                      @else
                        <span class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                          Nonaktif
                        </span>
                      @endif
                    </td>
                    <td class="flex items-center gap-3">
                      <form action="{{ route('dokter.jadwal-periksa.updateStatus', $jadwalPeriksa->id) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')
                        @if ($jadwalPeriksa->status == true)
                          <button type="submit" class="btn btn-icon btn-danger btn-sm">
                            <i class="fa-solid fa-circle-xmark inline-block mr-1"></i>
                            Nonaktifkan
                          </button>
                        @else
                          <button type="submit" class="btn btn-icon btn-success btn-sm">
                            <i class="fa-solid fa-circle-check inline-block mr-1"></i>
                            Aktifkan
                          </button>
                        @endif
                      </form>

                      <a href="{{ route('dokter.jadwal-periksa.edit', $jadwalPeriksa->id) }}"
                        class="btn btn-icon btn-warning btn-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>

                      <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwalPeriksa->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-icon btn-danger btn-sm">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-gray-500">
                      Tidak ada jadwal periksa yang tersedia.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div>
            {{ $jadwalPeriksas->links() }}
          </div>
        </section>
      </div>
    </div>
  </div>
</x-app-layout>
