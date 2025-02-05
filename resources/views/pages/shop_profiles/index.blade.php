@extends('layouts.app')

@section('title', 'Shop Profile')

@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha384-xodZBntMorA17cE6Bqy8BMKGzHkxjVRyDzt2EZ7bhD4MLUyZMivDDr2IC6Q8tiyP" crossorigin="" />

    <style>
        #create-map,
        #static-map {
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
                <h1>{{ isset($shopProfile) ? 'Detail Shop Profile' : 'Create Shop Profile' }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Shop Profile</div>
                </div>
            </div>

            <div class="section-body">
                {{-- Menampilkan Data Shop Profile --}}
                @if (isset($shopProfile))
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mt-3"><strong>Shop Name:</strong> {{ $shopProfile->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mt-3"><strong>Shop Type:</strong> {{ $shopProfile->shop_type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if ($shopProfile->photo)
                                <div class="form-group">
                                    <p><strong>Shop Photo:</strong></p>
                                    <img src="{{ Storage::url($shopProfile->photo) }}" alt="Shop Photo"
                                        class="d-block-center" style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mt-3"><strong>Open Time:</strong> {{ $shopProfile->open_time }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mt-3"><strong>Close Time:</strong> {{ $shopProfile->close_time }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <p><strong>Address:</strong> {{ $shopProfile->address }}</p>
                            <p><strong>Location:</strong>
                                {{ $shopProfile->location->latitude ?? '-' }},
                                {{ $shopProfile->location->longitude ?? '-' }}
                            </p>
                            <div id="static-map"></div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ isset($shopProfile) ? route('shop-profiles.update', $shopProfile->id) : route('shop-profiles.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($shopProfile))
                                @method('PUT')
                            @endif

                            {{-- Shop Name --}}
                            <div class="form-group">
                                <label for="name">Shop Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $shopProfile->name ?? '') }}" required>
                            </div>

                            {{-- Shop Type --}}
                            <div class="form-group">
                                <label for="shop_type">Shop Type</label>
                                <input type="text" name="shop_type" id="shop_type" class="form-control"
                                    value="{{ old('shop_type', $shopProfile->shop_type ?? '') }}" required>
                            </div>

                            {{-- Address --}}
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $shopProfile->address ?? '') }}</textarea>
                            </div>

                            {{-- Description --}}
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $shopProfile->description ?? '') }}</textarea>
                            </div>

                            {{-- Open Time --}}
                            <div class="form-group">
                                <label for="open_time">Open Time</label>
                                <input type="time" name="open_time" id="open_time" class="form-control"
                                    value="{{ old('open_time', $shopProfile->open_time ?? '') }}" required>
                            </div>

                            {{-- Close Time --}}
                            <div class="form-group">
                                <label for="close_time">Close Time</label>
                                <input type="time" name="close_time" id="close_time" class="form-control"
                                    value="{{ old('close_time', $shopProfile->close_time ?? '') }}" required>
                            </div>

                            {{-- Photo --}}
                            <div class="form-group">
                                <label for="photo">Shop Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                                @if (isset($shopProfile->photo))
                                    <p class="mt-2">Current Photo:</p>
                                    <img src="{{ Storage::url($shopProfile->photo) }}" alt="Current Photo"
                                        style="max-width: 150px; max-height: 150px;">
                                @endif
                            </div>

                            {{-- Latitude --}}
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    value="{{ old('latitude', $shopProfile->location->latitude ?? '-8.5003989') }}"
                                    required>
                            </div>

                            {{-- Longitude --}}
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control"
                                    value="{{ old('longitude', $shopProfile->location->longitude ?? '140.3659557') }}"
                                    required>
                            </div>

                            {{-- Map --}}
                            <div id="create-map"></div>

                            {{-- Submit Button --}}
                            <button type="submit" class="btn btn-primary mt-3">
                                {{ isset($shopProfile) ? 'Update Shop Profile' : 'Create Shop Profile' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Static Map (View-Only Mode)
        @if (isset($shopProfile))
            const staticMap = L.map('static-map').setView(
                [
                    {{ $shopProfile->location->latitude ?? '-8.5003989' }},
                    {{ $shopProfile->location->longitude ?? '140.3659557' }}
                ],
                13
            );

            // Esri Satellite Imagery Layer
            const satelliteLayer = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Earthstar Geographics, and the GIS User Community'
                }
            );

            // Esri Label Layer
            const labelLayer = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Labels &copy; Esri'
                }
            );

            // Add layers to static map
            satelliteLayer.addTo(staticMap);
            labelLayer.addTo(staticMap);

            // Add marker to static map
            L.marker([
                {{ $shopProfile->location->latitude ?? '-8.5003989' }},
                {{ $shopProfile->location->longitude ?? '140.3659557' }}
            ]).addTo(staticMap);
        @endif

        // Interactive Map (Create or Update Mode)
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const defaultLat = latitudeInput.value || -8.5003989;
        const defaultLng = longitudeInput.value || 140.3659557;

        const createMap = L.map('create-map').setView([defaultLat, defaultLng], 13);

        // Esri Satellite Imagery Layer
        const satelliteLayerInteractive = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Earthstar Geographics, and the GIS User Community'
            }
        );

        // Esri Label Layer
        const labelLayerInteractive = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Labels &copy; Esri'
            }
        );

        // Add layers to interactive map
        satelliteLayerInteractive.addTo(createMap);
        labelLayerInteractive.addTo(createMap);

        // Add draggable marker to interactive map
        const marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(createMap);

        // Update latitude and longitude inputs on marker drag
        marker.on('dragend', function(e) {
            const latLng = e.target.getLatLng();
            latitudeInput.value = latLng.lat;
            longitudeInput.value = latLng.lng;
        });

        // Update marker position on map click
        createMap.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            marker.setLatLng([lat, lng]);
            latitudeInput.value = lat;
            longitudeInput.value = lng;
        });

        // Geolocation: Get the user's current location and adjust map view
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Update map view to the user's location
                createMap.setView([userLat, userLng], 13);
                marker.setLatLng([userLat, userLng]);
                latitudeInput.value = userLat;
                longitudeInput.value = userLng;

                // Optionally, add a marker to indicate the user's current location
                L.marker([userLat, userLng])
                    .addTo(createMap)
                    .openPopup();
            });
        }

        // Function to add labels to buildings using OpenStreetMap data (for nearby places/landmarks)
        function addBuildingLabels() {
            // Esri Satellite Imagery Layer
            const satelliteLayer = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Earthstar Geographics, and the GIS User Community'
                }
            );
            satelliteLayer.addTo(createMap);
        }


        // Call the function to add building labels
        addBuildingLabels();
    </script>
@endpush
