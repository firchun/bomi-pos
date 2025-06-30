@extends('layouts.app')

@section('title', 'Create Package')
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Package</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('packages-account.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if (isset($packageDevice))
                                <input type="hidden" name="id" value="{{ $packageDevice->id }}">
                            @endif

                            <div class="form-group">
                                <label>Package Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $packageDevice->name ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Type (optional)</label>
                                <select name="type" class="form-control">
                                    <option value="">-- Select Type --</option>
                                    @php
                                        $types = ['Economical', 'Monthly', 'Yearly'];
                                        $selected = old('type', $packageDevice->type ?? '');
                                    @endphp
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}" {{ $selected == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price', $packageDevice->price ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Features</label>
                                <div id="feature-wrapper">
                                    @php
                                        $features = old('features', $packageDevice->features ?? ['']);
                                    @endphp
                                    @foreach ($features as $index => $feature)
                                        <div class="input-group mb-2">
                                            <input type="text" name="features[]" class="form-control"
                                                value="{{ $feature }}" placeholder="Feature...">
                                            <div class="input-group-append">
                                                <button class="btn btn-danger btn-remove-feature"
                                                    type="button">🗑️</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary" id="btn-add-feature">+ Add
                                    Feature</button>
                            </div>


                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('packages-account.index') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('btn-add-feature').addEventListener('click', function() {
            const wrapper = document.getElementById('feature-wrapper');
            const group = document.createElement('div');
            group.classList.add('input-group', 'mb-2');
            group.innerHTML = `
            <input type="text" name="features[]" class="form-control" placeholder="Feature...">
            <div class="input-group-append">
                <button class="btn btn-danger btn-remove-feature" type="button">🗑️</button>
            </div>
        `;
            wrapper.appendChild(group);
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-remove-feature')) {
                e.target.closest('.input-group').remove();
            }
        });
    </script>
@endpush
