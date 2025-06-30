@extends('layouts.app')

@section('title', 'Edit Package')
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Blog</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('packages-device.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $packageDevice->id }}">

                            <div class="form-group">
                                <label>Package Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $packageDevice->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Tag (optional)</label>
                                <input type="text" name="tag" class="form-control"
                                    value="{{ old('tag', $packageDevice->tag) }}">
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price', $packageDevice->price) }}" required>
                            </div>
                            <div class="form-group">
                                <label>No Hp for order</label>
                                <input type="number" name="no_hp" class="form-control"
                                    value="{{ old('no_hp', $packageDevice->no_hp ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Features</label>
                                <div id="feature-wrapper">
                                    @foreach (old('features', $packageDevice->features ?? []) as $feature)
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

                            <div class="form-group">
                                <label>Image (optional)</label>
                                <input type="file" name="image" class="form-control">
                                @if ($packageDevice->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $packageDevice->image) }}" alt="Preview"
                                            width="120" class="rounded">
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('packages-device.index') }}" class="btn btn-secondary">Back</a>
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
            if (e.target.classList.contains('btn-remove-feature')) {
                e.target.closest('.input-group').remove();
            }
        });
    </script>
@endpush
