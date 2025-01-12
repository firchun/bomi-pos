@extends('layouts.app')

@section('title', 'Admin Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Profile</h1>
                <div class="section-header-button">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Admin Profiles</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Admin Profile</h2>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <form
                                action="{{ isset($profile) ? route('admin_profiles.update', $profile->id) : route('admin_profiles.store') }}"
                                method="POST">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ isset($profile) ? 'Edit Admin Profile' : 'Create Admin Profile' }}</h4>
                                </div>
                                <div class="card-body">
                                    @if (isset($profile))
                                        @method('PUT')
                                    @endif

                                    <!-- About Ourselves -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">About Ourselves</label>
                                        <div id="about-ourselves">
                                            <div class="mb-3 p-3 border rounded bg-light">
                                                <input type="text" class="form-control mb-2"
                                                    name="about_ourselves[title]"
                                                    value="{{ old('about_ourselves.title', isset($profile) ? json_decode($profile->about_ourselves, true)['title'] : '') }}"
                                                    placeholder="Title">
                                                <textarea class="form-control" name="about_ourselves[description]" rows="2" placeholder="Description">{{ old('about_ourselves.description', isset($profile) ? json_decode($profile->about_ourselves, true)['description'] : '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Our Services -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Our Services</label>
                                        <textarea class="form-control" name="our_services" rows="3">{{ old('our_services', $profile->our_services ?? '') }}</textarea>
                                    </div>
                                    <!-- Our Services Items -->
                                    <div class="mb-4">
                                        <div id="our-services-items">
                                            @php
                                                $ourServicesItems = old(
                                                    'our_services_items',
                                                    isset($profile)
                                                        ? json_decode($profile->our_services_items, true)
                                                        : [],
                                                );
                                            @endphp
                                            @foreach ($ourServicesItems as $index => $item)
                                                <div class="mb-3 p-3 border rounded bg-light service-item">
                                                    <input type="text" class="form-control mb-2"
                                                        name="our_services_items[{{ $index }}][title]"
                                                        value="{{ $item['title'] }}" placeholder="Title">
                                                    <textarea class="form-control mb-2" name="our_services_items[{{ $index }}][description]" rows="2"
                                                        placeholder="Description">{{ $item['description'] }}</textarea>
                                                    <button type="button" class="btn btn-danger btn-sm mt-2"
                                                        onclick="removeItem(this, 'service-item')">Remove</button>
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                onclick="addServiceItem()">Add Service Item</button>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Difference of Us -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Difference of Us</label>
                                        <textarea class="form-control" name="difference_of_us" rows="3">{{ old('difference_of_us', $profile->difference_of_us ?? '') }}</textarea>
                                    </div>

                                    <!-- Difference Items -->
                                    <div class="mb-4">
                                        <div id="difference-items">
                                            @php
                                                $differenceItems = old(
                                                    'difference_of_us_items',
                                                    isset($profile)
                                                        ? json_decode($profile->difference_of_us_items, true)
                                                        : [],
                                                );
                                            @endphp
                                            @foreach ($differenceItems as $index => $item)
                                                <div class="mb-3 p-3 border rounded bg-light difference-item">
                                                    <input type="text" class="form-control mb-2"
                                                        name="difference_of_us_items[{{ $index }}][title]"
                                                        value="{{ $item['title'] }}" placeholder="Title">
                                                    <textarea class="form-control mb-2" name="difference_of_us_items[{{ $index }}][description]" rows="2"
                                                        placeholder="Description">{{ $item['description'] }}</textarea>
                                                    <button type="button" class="btn btn-danger btn-sm mt-2"
                                                        onclick="removeItem(this, 'difference-item')">Remove</button>
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                onclick="addDifferenceItem()">Add Difference Item</button>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="card-footer text-right">
                                        <button type="submit"
                                            class="btn btn-primary">{{ isset($profile) ? 'Update' : 'Submit' }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function addServiceItem() {
            const container = document.getElementById('our-services-items');
            const items = container.querySelectorAll('.service-item');
            const index = items.length; // Tentukan indeks berdasarkan jumlah elemen saat ini
            const item = document.createElement('div');
            item.classList.add('mt-3','mb-3', 'p-3', 'border', 'rounded', 'bg-light', 'service-item');
            item.innerHTML = `
        <input type="text" class="form-control mb-2" name="our_services_items[${index}][title]" placeholder="Title">
        <textarea class="form-control mb-2" name="our_services_items[${index}][description]" rows="2" placeholder="Description"></textarea>
        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeItem(this, 'service-item')">Remove</button>
    `;
            container.appendChild(item);
        }

        function addDifferenceItem() {
            const container = document.getElementById('difference-items');
            const items = container.querySelectorAll('.difference-item');
            const index = items.length; // Tentukan indeks berdasarkan jumlah elemen saat ini
            const item = document.createElement('div');
            item.classList.add('mt-3','mb-3', 'p-3', 'border', 'rounded', 'bg-light', 'difference-item');
            item.innerHTML = `
        <input type="text" class="form-control mb-2" name="difference_of_us_items[${index}][title]" placeholder="Title">
        <textarea class="form-control mb-2" name="difference_of_us_items[${index}][description]" rows="2" placeholder="Description"></textarea>
        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeItem(this, 'difference-item')">Remove</button>
    `;
            container.appendChild(item);
        }

        function removeItem(button, itemClass) {
            const item = button.parentElement; // Pilih elemen induk tombol "Remove"
            item.remove(); // Hapus elemen dari DOM

            // Perbarui indeks elemen lainnya
            if (itemClass === 'service-item') {
                updateServiceItemIndexes();
            } else if (itemClass === 'difference-item') {
                updateDifferenceItemIndexes();
            }
        }

        function updateServiceItemIndexes() {
            const items = document.querySelectorAll('.service-item');
            items.forEach((item, index) => {
                item.querySelector('input').setAttribute('name', `our_services_items[${index}][title]`);
                item.querySelector('textarea').setAttribute('name', `our_services_items[${index}][description]`);
            });
        }

        function updateDifferenceItemIndexes() {
            const items = document.querySelectorAll('.difference-item');
            items.forEach((item, index) => {
                item.querySelector('input').setAttribute('name', `difference_of_us_items[${index}][title]`);
                item.querySelector('textarea').setAttribute('name',
                `difference_of_us_items[${index}][description]`);
            });
        }
    </script>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
