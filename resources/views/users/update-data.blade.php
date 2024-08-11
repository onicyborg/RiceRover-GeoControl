@extends('layout.master')

@section('title')
    UPDATE DATA LAHAN
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Form Update Lahan</h3>
    </div>
    <div class="page-content">
        <div class="row">
            <!-- Form Input -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Data Lahan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="map" style="width: 100%; height: 400px;"></div>
                                <div class="form-check form-switch mt-3">
                                    <input class="form-check-input" type="checkbox" id="use_current_location">
                                    <label class="form-check-label" for="use_current_location">Pilih lokasi saat ini</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="/update-data-lahan/{{ $lahan->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nama_lahan">Nama Petani / Kelompok Tani</label>
                                        <input type="text" id="nama_kelompok_tani" name="nama_kelompok_tani"
                                            value="{{ $lahan->nama_kelompok_tani }}"
                                            class="form-control @error('nama_kelompok_tani') is-invalid @enderror">
                                        @error('nama_kelompok_tani')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lahan">Nomor Kartu Tani (Jika Ada)</label>
                                        <input type="number" id="nomor_kartu_tani" name="nomor_kartu_tani"
                                            value="{{ $lahan->nomor_kartu_tani }}"
                                            class="form-control @error('nomor_kartu_tani') is-invalid @enderror">
                                        @error('nomor_kartu_tani')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lahan">Nama Lahan</label>
                                        <input type="text" id="nama_lahan" name="nama_lahan" value="{{ $lahan->nama_lahan }}"
                                            class="form-control @error('nama_lahan') is-invalid @enderror">
                                        @error('nama_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="luas_lahan">Luas Lahan (M2)</label>
                                        <input type="number" id="luas_lahan" name="luas_lahan" value="{{ $lahan->luas_lahan }}"
                                            class="form-control @error('luas_lahan') is-invalid @enderror">
                                        @error('luas_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="isi_lahan">Isi Lahan</label>
                                        <input type="text" id="isi_lahan" name="isi_lahan" value="{{ $lahan->isi_lahan }}"
                                            class="form-control @error('isi_lahan') is-invalid @enderror">
                                        @error('isi_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pemilik_lahan">Pemilik Lahan</label>
                                        <input type="text" id="pemilik_lahan" name="pemilik_lahan" value="{{ $lahan->pemilik_lahan }}"
                                            class="form-control @error('pemilik_lahan') is-invalid @enderror">
                                        @error('pemilik_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat_lahan">Alamat Lahan</label>
                                        <textarea id="alamat_lahan" name="alamat_lahan"
                                            class="form-control @error('alamat_lahan') is-invalid @enderror">{{ $lahan->alamat_lahan }}</textarea>
                                        @error('alamat_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="denah_lahan">Denah Lahan</label>
                                        <input type="text" id="denah_lahan" name="denah_lahan" value="{{ $lahan->denah_lahan }}"
                                            class="form-control @error('denah_lahan') is-invalid @enderror"
                                            placeholder="Klik Di Peta / Pilih Lokasi Saat Ini" readonly>
                                        @error('denah_lahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar">Gambar (Kosongkan jika tidak ingin mengubah)</label>
                                        <input type="file" id="gambar" name="gambar"
                                            class="form-control @error('gambar') is-invalid @enderror">
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if($lahan->gambar)
                                        <div class="form-group mt-2">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#gambarModal">Lihat Gambar Saat Ini</a>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="hasil_panen">Total Hasil Panen (Kg)</label>
                                        <input type="number" id="hasil_panen" name="hasil_panen" value="{{ $lahan->hasil_panen }}"
                                            class="form-control @error('hasil_panen') is-invalid @enderror">
                                        @error('hasil_panen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="awal_tanam">Awal Tanam</label>
                                        <input type="date" id="awal_tanam" name="awal_tanam" value="{{ $lahan->awal_tanam }}"
                                            class="form-control @error('awal_tanam') is-invalid @enderror">
                                        @error('awal_tanam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="akhir_tanam">Akhir Tanam</label>
                                        <input type="date" id="akhir_tanam" name="akhir_tanam" value="{{ $lahan->akhir_tanam }}"
                                            class="form-control @error('akhir_tanam') is-invalid @enderror">
                                        @error('akhir_tanam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="gambarModal" tabindex="-1" aria-labelledby="gambarModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gambarModalLabel">Gambar Saat Ini</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if($lahan->gambar)
                                        <img src="{{ asset('storage/uploads/' . $lahan->gambar) }}" alt="Gambar Lahan" style="width: 100%;">
                                    @else
                                        <p>Tidak ada gambar yang tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .leaflet-container {
            z-index: 1;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([{{ $lahan->denah_lahan }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker = L.marker([{{ $lahan->denah_lahan }}]).addTo(map);

        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('denah_lahan').value = e.latlng.lat + ", " + e.latlng.lng;
        }

        map.on('click', onMapClick);

        document.getElementById('use_current_location').addEventListener('change', function() {
            if (this.checked) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        var latlng = L.latLng(lat, lng);
                        map.setView(latlng, 13);
                        if (marker) {
                            map.removeLayer(marker);
                        }
                        marker = L.marker(latlng).addTo(map);
                        document.getElementById('denah_lahan').value = lat + ", " + lng;
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }
        });
    </script>
@endpush
