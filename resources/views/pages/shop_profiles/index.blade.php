@extends('layouts.app')

@section('title', 'Shop Profile')

@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ isset($shopProfile) ? 'Update' : 'Create' }} Shop Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
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
                                                    class="img-thumbnail d-block mx-auto" style="max-width: 370px;">
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

                            <button type="submit" class="btn btn-primary">
                                {{ isset($shopProfile) ? 'Update' : 'Create' }} Shop Profile
                            </button>

                            <!-- Lihat Shop Profile Button -->
                            @if (isset($shopProfile))
                                <a href="{{ route('shop.details', $shopProfile->slug) }}" class="btn btn-secondary ms-2">
                                    Lihat Shop Profile
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
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
