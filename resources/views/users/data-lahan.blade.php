@extends('layout.master')

@section('title')
    DATA LAHAN
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Data Lahan</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Table Data Lahan</span>
                    <a href="/user/add-lahan" class="btn btn-primary">Tambah Lahan</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lahan</th>
                            <th>Luas Lahan</th>
                            <th>Isi Lahan</th>
                            <th>Pemilik Lahan</th>
                            <th>Total Hasil Panen</th>
                            <th>Status Lahan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lahans as $index => $lahan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lahan->nama_lahan }}</td>
                                <td>{{ $lahan->luas_lahan }} M&sup2;</td>
                                <td>{{ $lahan->isi_lahan }}</td>
                                <td>{{ $lahan->pemilik_lahan }}</td>
                                <td>{{ $lahan->hasil_panen }} Kg</td>
                                <td>{{ $lahan->status == 'berjalan' ? 'Belum Selesai Masa Panen' : 'Selesai Masa Panen' }}
                                </td>
                                <td>
                                    <a href="/user/update-data-lahan/{{ $lahan->id }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/user/data-alokasi/{{ $lahan->id }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($lahan->status == 'berjalan')
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#modalSelesai{{ $lahan->id }}">
                                            <i class="bi bi-check2-circle"></i>
                                        </button>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Peta Lokasi Lahan</h4>
            </div>
            <div class="card-body">
                <div id="map" style="height: 800px;"></div>
            </div>
        </div>
    </div>

    @foreach ($lahans as $lahan)
        @if ($lahan->status == 'berjalan')
            <!-- Modal -->
            <div class="modal fade" id="modalSelesai{{ $lahan->id }}" tabindex="-1"
                aria-labelledby="modalSelesaiLabel{{ $lahan->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSelesaiLabel{{ $lahan->id }}">Konfirmasi Selesai Masa Panen
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin mengubah status lahan <strong>{{ $lahan->nama_lahan }}</strong> menjadi
                            "Selesai Masa Panen"? Action ini tidak dapat di kembalikan dan lahan ini tidak akan mendapat
                            alokasi pupuk lagi.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="/update-status-lahan/{{ $lahan->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Ya, Ubah Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/leaflet/leaflet.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .leaflet-container {
            z-index: 1;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendors/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('geojson/leaflet.ajax.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        // Leaflet Map
        var map = L.map('map');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Array to store all bounds
        var allBounds = [];

        // Loop through lahan data and add polygons
        @foreach ($lahans as $lahan)
            @if ($lahan->denah_lahan)
                var geojsonData = {
                    "type": "Feature",
                    "geometry": {
                        "type": "MultiPolygon",
                        "coordinates": {!! $lahan->denah_lahan !!}
                    },
                    "properties": {
                        "name": "{{ $lahan->nama_lahan }}"
                    }
                };

                // Add GeoJSON layer and get its bounds
                var geoJsonLayer = L.geoJSON(geojsonData).addTo(map).bindPopup(`
                    <div style="width: 300px;">
                        <h4>{{ $lahan->nama_lahan }}</h4>
                        <p><b>Nama Kelompok Tani:</b> {{ $lahan->nama_kelompok_tani }}</p>
                        <p><b>Nomor Kartu Tani:</b> {{ $lahan->nomor_kartu_tani ? $lahan->nomor_kartu_tani : '-' }}</p>
                        <p><b>Luas Lahan:</b> {{ $lahan->luas_lahan }} M2</p>
                        <p><b>Isi Lahan:</b> {{ $lahan->isi_lahan }}</p>
                        <p><b>Pemilik Lahan:</b> {{ $lahan->pemilik_lahan }}</p>
                        <p><b>Alamat Lahan:</b> {{ $lahan->alamat_lahan }}</p>
                        <p><b>Hasil Panen:</b> {{ $lahan->hasil_panen }} Kg</p>
                        <p><b>Awal Tanam:</b> {{ $lahan->awal_tanam }}</p>
                        <p><b>Akhir Tanam:</b> {{ $lahan->akhir_tanam }}</p>
                        <p><b>Gambar:</b></p>
                        <img src="{{ asset('/storage/uploads/' . $lahan->gambar) }}" alt="Gambar Lahan" style="width: 100%; height: auto;">
                    </div>
                `);
                allBounds.push(geoJsonLayer.getBounds());
            @endif
        @endforeach

        // Fit the map to show all bounds
        if (allBounds.length > 0) {
            if (allBounds.length === 1) {
                map.fitBounds(allBounds[0]);
            } else {
                var combinedBounds = allBounds[0];
                for (var i = 1; i < allBounds.length; i++) {
                    combinedBounds.extend(allBounds[i]);
                }
                map.fitBounds(combinedBounds);
            }
        } else {
            // Set default view if no geometries are present
            map.setView([-6.927806803218691, 106.93018482302313], 13);
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
