<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in! Welcome ") }} {{ Auth::user()->nama }}
                </div>
            <table class="table mt-6 overflow-hidden rounded table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Poliklinik</th>
                            <th scope="col">Dokter</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Mulai</th>
                            <th scope="col">Selesai</th>
                            <th scope="col">Antrian</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($janjiPeriksas as $janjiPeriksa)
                            <tr>
                                <th scope="row" class="align-middle text-start">{{ $loop->iteration }}</th>
                                <td class="align-middle text-start">
                                    {{ $janjiPeriksa->jadwalPeriksa->dokter->poli->nama ?? 'N/A' }}</td>
                                <td class="align-middle text-start">
                                    {{ $janjiPeriksa->jadwalPeriksa->dokter->nama }}</td>
                                <td class="align-middle text-start">{{ $janjiPeriksa->jadwalPeriksa->hari }}</td>
                                <td class="align-middle text-start">
                                    {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_mulai)->format('H.i') }}
                                </td>
                                <td class="align-middle text-start">
                                    {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_selesai)->format('H.i') }}
                                </td>
                                <td class="align-middle text-start">{{ $janjiPeriksa->no_antrian }}</td>
                                <td class="align-middle text-start">
                                    @if (is_null($janjiPeriksa->periksa))
                                        <span class="badge badge-pill badge-warning">Belum Diperiksa</span>
                                    @else
                                        <span class="badge badge-pill badge-success">Sudah Diperiksa</span>
                                    @endif
                                </td>
                                <td class="align-middle text-start">
                                    @if (is_null($janjiPeriksa->periksa))
                                        <a href="{{route('pasien.riwayat-periksa.detail', $janjiPeriksa->id)}}" class="btn btn-info">Detail</a>

                                        <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg" id="detailModal{{ $janjiPeriksa->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="detailModalTitle{{ $janjiPeriksa->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-bold"
                                                            id="riwayatModalLabel{{ $janjiPeriksa->id }}">
                                                            Detail Riwayat Pemeriksaan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                <strong>Poliklinik:</strong>
                                                                {{ $janjiPeriksa->jadwalPeriksa->dokter->poli->nama ?? 'N/A'  }}
                                                            </li>
                                                            <li class="list-group-item">
                                                                <strong>Nama Dokter:</strong>
                                                                {{ $janjiPeriksa->jadwalPeriksa->dokter->nama }}
                                                            </li>
                                                            <li class="list-group-item">
                                                                <strong>Hari Pemeriksaan:</strong>
                                                                {{ $janjiPeriksa->jadwalPeriksa->hari }}
                                                            </li>
                                                            <li class="list-group-item">
                                                                <strong>Jam Mulai:</strong>
                                                                {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_mulai)->format('H.i') }}
                                                            </li>
                                                            <li class="list-group-item">
                                                                <strong>Jam Selesai:</strong>
                                                                {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_selesai)->format('H.i') }}
                                                            </li>
                                                        </ul>

                                                        <!-- Highlight Nomor Antrian -->
                                                        <div class="mt-4 text-center">
                                                            <div class="mb-2 h5 font-weight-bold">Nomor Antrian Anda
                                                            </div>
                                                            <span class="badge badge-primary"
                                                                style="font-size: 1.75rem; padding: 0.6em 1.2em;">
                                                                {{ $janjiPeriksa->no_antrian }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            Tutup
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{route('pasien.riwayat-periksa.riwayat', $janjiPeriksa->id)}}" class="btn btn-secondary">Riwayat</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                                <tr>
                                <td colspan="9" class="align-middle text-center">
                                    <div class="py-8">
                                    <i class="fas fa-history text-gray-400 text-6xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Periksa</h3>
                                    <p class="text-gray-600">Anda belum membuat janji periksa.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $janjiPeriksas->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
