@extends('layout.master')

@section('title')
    DASHBOARD
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Profile Statistics</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldHome"></i> <!-- Ikon untuk Total Lahan Terdaftar -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Lahan Terdaftar</h6>
                                        <h6 class="font-extrabold mb-0">{{ $total_lahan }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldTick-Square"></i> <!-- Ikon untuk Alokasi Terealisasi -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Alokasi Terealisasi</h6>
                                        <h6 class="font-extrabold mb-0">{{ $alokasi }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldUser1"></i> <!-- Ikon untuk Jumlah Penggarap -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Jumlah Penggarap</h6>
                                        <h6 class="font-extrabold mb-0">{{ $penggarap }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldCalendar"></i> <!-- Ikon untuk Lahan Selesai Masa Panen -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Lahan Selesai Masa Panen</h6>
                                        <h6 class="font-extrabold mb-0">{{ $lahan_selesai }}</h6>
                                        <!-- Ganti dengan data dinamis -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                @if (Auth::user()->avatar != '')
                                    <img src="{{ asset('storage/uploads/' . Auth::user()->avatar) }}" alt="Face 1">
                                @else
                                    <img src="{{ asset('assets/images/faces/1.jpg') }}" alt="Face 1">
                                @endif
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">{{ '@' . Auth::user()->username }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lokasi Lahan</h5>
                        <div id="map" style="height: 500px;"></div> <!-- Ukuran peta ditentukan oleh height -->
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/leaflet/leaflet.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendors/leaflet/leaflet.js') }}"></script>
    <script>

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
                    <p><b>Penggarap Lahan:</b> {{ $lahan->user->name }}</p>
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
