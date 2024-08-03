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
                            <th>Hasil Tanam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lahans as $index => $lahan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lahan->nama_lahan }}</td>
                                <td>{{ $lahan->luas_lahan }}</td>
                                <td>{{ $lahan->isi_lahan }}</td>
                                <td>{{ $lahan->pemilik_lahan }}</td>
                                <td>{{ $lahan->hasil_tanam }}</td>
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
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        // Leaflet Map
        var map = L.map('map').setView([-6.200000, 106.816666], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markers = [];

        @foreach ($lahans as $lahan)
            @if ($lahan->denah_lahan)
                var coords = '{{ $lahan->denah_lahan }}'.split(', ');
                var marker = L.marker([parseFloat(coords[0]), parseFloat(coords[1])]).addTo(map)
                    .bindPopup(`
                <div style="width: 300px;">
                    <h4>{{ $lahan->nama_lahan }}</h4>
                    <p><b>Luas Lahan:</b> {{ $lahan->luas_lahan }} M2</p>
                    <p><b>Isi Lahan:</b> {{ $lahan->isi_lahan }}</p>
                    <p><b>Pemilik Lahan:</b> {{ $lahan->pemilik_lahan }}</p>
                    <p><b>Alamat Lahan:</b> {{ $lahan->alamat_lahan }}</p>
                    <p><b>Hasil Tanam:</b> {{ $lahan->hasil_tanam }}</p>
                    <p><b>Awal Tanam:</b> {{ $lahan->awal_tanam }}</p>
                    <p><b>Akhir Tanam:</b> {{ $lahan->akhir_tanam }}</p>
                    <p><b>Gambar:</b></p>
                    <img src="{{ Storage::url($lahan->gambar) }}" alt="Gambar Lahan" style="width: 100%; height: auto;">
                </div>
            `, {
                        maxWidth: "auto"
                    });

                markers.push([parseFloat(coords[0]), parseFloat(coords[1])]);
            @endif
        @endforeach

        if (markers.length > 0) {
            var bounds = L.latLngBounds(markers);
            map.fitBounds(bounds);
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
