@extends('layout.master')

@section('title')
    ALOKASI PUPUK PADA DATA LAHAN
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Detail Informasi Lahan</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Informasi Lahan</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Penggarap Lahan:</strong> {{ $lahan->user->name }}</p>
                        <p><strong>Nama Lahan:</strong> {{ $lahan->nama_lahan }}</p>
                        <p><strong>Luas Lahan:</strong> {{ $lahan->luas_lahan }} M2</p>
                        <p><strong>Isi Lahan:</strong> {{ $lahan->isi_lahan }}</p>
                        <p><strong>Pemilik Lahan:</strong> {{ $lahan->pemilik_lahan }}</p>
                        <p><strong>Alamat Lahan:</strong> {{ $lahan->alamat_lahan }}</p>
                        <p><strong>Hasil Panen:</strong> {{ $lahan->hasil_panen }} Kg</p>
                        <p><strong>Awal Tanam:</strong> {{ $lahan->awal_tanam }}</p>
                        <p><strong>Akhir Tanam:</strong> {{ $lahan->akhir_tanam }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Gambar Lahan:</strong></p>
                        <img src="{{ asset('/storage/uploads/' . $lahan->gambar) }}" alt="Gambar Lahan"
                            style="width: 100%; height: auto;">
                    </div>
                </div>

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>List Alokasi Pupuk</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penanggung Jawab</th>
                            <th>Musim Tanam Ke</th>
                            <th>Jenis / Nama Pupuk</th>
                            <th>Jumlah Alokasi</th>
                            <th>Total Nilai Alokasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lahan->alokasi_pupuk as $index => $alokasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $alokasi->nama_penanggung_jawab }}</td>
                                <td>{{ $alokasi->musim_tanam }}</td>
                                <td>{{ $alokasi->jenis_pupuk }}</td>
                                <td>{{ number_format($alokasi->jumlah_pupuk) }} Kg</td>
                                <td>Rp. {{ number_format($alokasi->total_nilai_subsidi) }}</td>
                                <td>
                                    <!-- Button Detail -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $alokasi->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $alokasi->id }}" tabindex="-1"
                                aria-labelledby="detailModalLabel{{ $alokasi->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel{{ $alokasi->id }}">Detail Alokasi Pupuk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Tampilkan detail alokasi pupuk -->
                                            <p><strong>Nama Penanggung Jawab:</strong> {{ $alokasi->nama_penanggung_jawab }}</p>
                                            <p><strong>Musim Tanam Ke:</strong> {{ $alokasi->musim_tanam }}</p>
                                            <p><strong>Jenis Pupuk:</strong> {{ $alokasi->jenis_pupuk }}</p>
                                            <p><strong>Jumlah Pupuk:</strong> {{ number_format($alokasi->jumlah_pupuk) }} Kg</p>
                                            <p><strong>Total Nilai Subsidi:</strong> Rp. {{ number_format($alokasi->total_nilai_subsidi) }}</p>

                                            <!-- Tambahkan gambar bukti distribusi -->
                                            <p><strong>Foto Bukti Distribusi:</strong></p>
                                            <img src="{{ Storage::url('uploads/' . $alokasi->foto_bukti_distribusi) }}" alt="Foto Bukti Distribusi" class="img-fluid mb-3">

                                            <!-- Tambahkan gambar tanda tangan -->
                                            <p><strong>Foto Tanda Tangan:</strong></p>
                                            <img src="{{ Storage::url('uploads/' . $alokasi->foto_tanda_tangan) }}" alt="Foto Tanda Tangan" class="img-fluid mb-3">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        var map = L.map('map').setView([{{ $lahan->denah_lahan }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

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

            map.setView([parseFloat(coords[0]), parseFloat(coords[1])], 15);
        @endif


        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        // Menggunakan class atau attribute selector untuk mengikat event listener ke elemen input
        document.querySelectorAll('.jumlah-pupuk, .harga-pupuk').forEach(function(input) {
            input.addEventListener('input', calculateTotalSubsidi);
        });

        function calculateTotalSubsidi() {
            // Mendapatkan elemen input terkait dari elemen yang sedang diubah
            const form = this.closest('form');
            let jumlah = parseFloat(form.querySelector('.jumlah-pupuk').value) || 0;
            let harga = parseFloat(form.querySelector('.harga-pupuk').value) || 0;
            let total = jumlah * harga;
            form.querySelector('.total-nilai-subsidi').value = total;
        }

        document.getElementById('jumlah_pupuk').addEventListener('input', calculateTotalSubsidi2);
        document.getElementById('harga_pupuk').addEventListener('input', calculateTotalSubsidi2);

        function calculateTotalSubsidi2() {
            let jumlah = parseFloat(document.getElementById('jumlah_pupuk').value) || 0;
            let harga = parseFloat(document.getElementById('harga_pupuk').value) || 0;
            let total = jumlah * harga;
            document.getElementById('total_nilai_subsidi').value = total;
        }


        function setupUpdateFormListeners(alokasiId) {
            const jumlahInput = document.getElementById(`jumlah_pupuk${alokasiId}`);
            const hargaInput = document.getElementById(`harga_pupuk${alokasiId}`);
            const totalInput = document.getElementById(`total_nilai_subsidi${alokasiId}`);

            function calculateTotalSubsidi() {
                let jumlah = parseFloat(jumlahInput.value) || 0;
                let harga = parseFloat(hargaInput.value) || 0;
                let total = jumlah * harga;
                totalInput.value = total;
            }

            jumlahInput.addEventListener('input', calculateTotalSubsidi);
            hargaInput.addEventListener('input', calculateTotalSubsidi);
        }
    </script>
@endpush
