@extends('layouts.app')

@section('title', 'Product Create')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">@yield('title')</h2>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text"
                                            class="form-control @error('name')
                                is-invalid
                            @enderror"
                                            name="name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>HPP</label>
                                        <input type="number"
                                            class="form-control @error('hpp')
                                                is-invalid
                                            @enderror"
                                            name="hpp">
                                        @error('hpp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number"
                                            class="form-control @error('price')
                                                is-invalid
                                            @enderror"
                                            name="price">
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea
                                            class="summernote-simple @error('description')
                                              is-invalid
                                          @enderror"
                                            name="description"></textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <select class="form-control selectric @error('category_id') is-invalid @enderror"
                                            name="category_id">
                                            <option value="">Choose Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Photo Product</label>

                                        <input type="file" class="form-control" name="image"
                                            @error('image') is-invalid @enderror>

                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="text-mutted mt-3">
                                        @if (app()->getLocale() == 'en')
                                            Maximum photo size is 2 MB, and the recommended photo size is 300 x 300 pixels.
                                          @else
                                            ukuran maksimal foto 2 MB, dan ukuran foto yang disarankan adalah 300 x 300 pixel.
                                          @endif
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="selectgroup selectgroup-pills">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="status" value="1"
                                                    class="selectgroup-input" checked="">
                                                <span class="selectgroup-button">Active</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="status" value="0"
                                                    class="selectgroup-input">
                                                <span class="selectgroup-button">Inactive</span>
                                            </label>
                                        </div>
                                    </div> --}}

                                    {{-- is favorite --}}
                                    {{-- <div class="form-group">
                                        <label class="form-label">Is Favorite</label>
                                        <div class="selectgroup selectgroup-pills">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="is_favorite" value="1"
                                                    class="selectgroup-input" checked="">
                                                <span class="selectgroup-button">Yes</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="is_favorite" value="0"
                                                    class="selectgroup-input">
                                                <span class="selectgroup-button">No</span>
                                            </label>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="card-footer text-center">
                                    <button class="btn btn-lg btn-primary"><i class="fa fa-save"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
@endpush
