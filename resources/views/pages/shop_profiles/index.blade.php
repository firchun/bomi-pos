@extends('layouts.app')

@section('title', 'Shop Profile')

@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #create-map {
            height: 400px;
            width: 100%;
        }

        .d-block-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .modal-backdrop {
            display: none !important;
        }

        .custom-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            /* Warna backdrop */
            z-index: 2000;
            /* Harus lebih rendah dari modal */
        }

        #qrModal {
            z-index: 3000 !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ isset($shopProfile) ? 'Update' : 'Create' }} Shop Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Shop Profile</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div id="success-message" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div id="error-message" class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <script>
                            setTimeout(function() {
                                $('#success-message').fadeOut('slow');
                                $('#error-message').fadeOut('slow');
                            }, 2000); // 1000ms = 1 detik
                        </script>
                        <form
                            action="{{ isset($shopProfile) ? route('shop-profiles.update', $shopProfile) : route('shop-profiles.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($shopProfile))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Shop Name, Shop Type, Address, and other details with col-8 -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Shop Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', $shopProfile->name ?? '') }}" required
                                            {{ isset($shopProfile) ? '' : 'autofocus' }}>
                                    </div>

                                    <div class="form-group">
                                        <label for="shop_type">Shop Type</label>
                                        <input type="text" name="shop_type" id="shop_type" class="form-control"
                                            value="{{ old('shop_type', $shopProfile->shop_type ?? '') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $shopProfile->address ?? '') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="6" required>{{ old('description', $shopProfile->description ?? '') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="open_time">Open Time</label>
                                        <input type="time" name="open_time" id="open_time" class="form-control"
                                            value="{{ old('open_time', $shopProfile->open_time ?? '08:00') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="close_time">Close Time</label>
                                        <input type="time" name="close_time" id="close_time" class="form-control"
                                            value="{{ old('close_time', $shopProfile->close_time ?? '17:00') }}" required>
                                    </div>
                                </div>

                                <!-- Shop Photo section with col-4 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="photo">Shop Photo</label>
                                        @if (isset($shopProfile) && $shopProfile->photo)
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($shopProfile->photo) }}" alt="Shop Photo"
                                                    class="img-thumbnail d-block mx-auto">
                                            </div>
                                        @endif
                                        <input type="file" name="photo" id="photo" class="form-control mt-2">
                                    </div>

                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" class="form-control"
                                            value="{{ old('latitude', $shopProfile->location->latitude ?? '-8.5003989') }}"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" name="longitude" id="longitude" class="form-control"
                                            value="{{ old('longitude', $shopProfile->location->longitude ?? '140.3659557') }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <!-- Map Section (separate card with col-12) -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div id="map" style="height: 400px; border-radius: 8px;"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary m-1">
                                {{ isset($shopProfile) ? 'Update' : 'Create' }} Shop Profile
                            </button>

                            <!-- Lihat Shop Profile Button -->
                            @if (isset($shopProfile))
                                <a href="{{ route('shop.details', $shopProfile->slug) }}" class="btn btn-secondary m-1">
                                    Lihat Shop Profile
                                </a>
                                <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                                    data-bs-target="#qrModal">
                                    Generate QR Code Menu
                                </button>
                            @endif


                            <!-- Modal untuk Generate QR Code -->
                            <div class="modal fade custom-modal-backdrop" id="qrModal" tabindex="-1"
                                aria-labelledby="qrModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="qrModalLabel">Generate QR Code Menu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Nama Toko: <strong>{{ $shopProfile->name ?? '' }}</strong> - Menu</p>
                                            <label for="qrCount">Masukkan jumlah QR Code:</label>
                                            <input type="number" id="qrCount" class="form-control mb-3"
                                                placeholder="Jumlah QR Code" min="1">
                                            <label for="customTables">Atau masukkan nomor meja secara custom (pisahkan
                                                dengan koma):</label>
                                            <input type="text" id="customTables" class="form-control mb-3"
                                                placeholder="Contoh: 1,2,3">
                                            <button type="button" class="btn btn-primary w-100"
                                                id="generateQrBtn">Generate</button>
                                            <div id="qrResults" class="mt-4 text-center"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let qrModal = document.getElementById('qrModal');

            qrModal.addEventListener('show.bs.modal', function() {
                // Hapus backdrop default sebelum modal muncul
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            });

            qrModal.addEventListener('hidden.bs.modal', function() {
                // Hapus backdrop jika ada saat modal ditutup
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            });
        });

        // Pastikan mengirim array sebagai JSON
        document.getElementById('generateQrBtn').addEventListener('click', function() {
            const countInput = document.getElementById('qrCount');
            const customInput = document.getElementById('customTables');

            // Validasi input
            let tables = [];
            if (customInput.value.trim()) {
                tables = customInput.value.split(',').map(t => t.trim()).filter(t => t !== "");
            } else if (countInput.value > 0) {
                tables = Array.from({
                    length: countInput.value
                }, (_, i) => (i + 1).toString());
            }

            if (tables.length === 0) {
                alert('Mohon isi jumlah QR atau nomor meja!');
                return;
            }

            // Kirim request
            fetch("{{ route('qr.generate.pdf') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        tables
                    })
                })
                .then(response => {
                    if (!response.ok) return response.json().then(err => {
                        throw err;
                    });
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob); // Buat URL dari Blob
                    window.open(url, "_blank"); // Buka di tab baru
                })
                .catch(error => {
                    alert(error.error || 'Error: Cek input dan coba lagi!');
                });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil data lokasi dari backend atau atur sebagai null jika tidak ada
            let initialLat = {{ $shopProfile->location->latitude ?? 'null' }};
            let initialLng = {{ $shopProfile->location->longitude ?? 'null' }};
            const shopName = "{{ $shopProfile->name ?? 'New Shop' }}";

            // Fungsi untuk memperbarui koordinat di form
            function updateCoordinates(lat, lng) {
                if (document.getElementById('latitude') && document.getElementById('longitude')) {
                    document.getElementById('latitude').value = lat.toFixed(7);
                    document.getElementById('longitude').value = lng.toFixed(7);
                }
            }

            // Fungsi untuk memuat peta dengan koordinat yang diberikan
            function loadMap(lat, lng) {
                const map = L.map('map').setView([lat, lng], 13);

                // Esri Satellite Layer
                L.tileLayer(
                    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                        attribution: 'Tiles © Esri'
                    }).addTo(map);

                // Tambahkan marker
                let marker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(map)
                    .bindPopup(`<b>${shopName}</b><br>Drag marker to adjust location`);

                // Update koordinat saat marker dipindah
                marker.on('dragend', function(e) {
                    const newLatLng = e.target.getLatLng();
                    updateCoordinates(newLatLng.lat, newLatLng.lng);
                });

                // Update marker saat peta diklik
                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    updateCoordinates(e.latlng.lat, e.latlng.lng);
                });

                // Perbarui koordinat di input form
                updateCoordinates(lat, lng);
            }

            // Jika data lokasi dari backend kosong, gunakan geolocation
            if (initialLat === null || initialLng === null) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;
                            loadMap(userLat, userLng);
                        },
                        function(error) {
                            console.log('Geolocation error:', error);
                            // Jika pengguna menolak akses lokasi, gunakan koordinat default
                            loadMap(-8.5003989, 140.3659557);
                        }
                    );
                } else {
                    // Jika browser tidak mendukung geolocation, gunakan koordinat default
                    loadMap(-8.5003989, 140.3659557);
                }
            } else {
                // Jika data lokasi ada dari backend, gunakan lokasi tersebut
                loadMap(parseFloat(initialLat), parseFloat(initialLng));
            }
        });
    </script>
@endpush
