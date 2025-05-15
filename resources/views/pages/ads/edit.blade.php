@extends('layouts.app')

@if (app()->getLocale() == 'en')
@section('title', 'Edit Advertisement')
@else
@section('title', 'Sunting Iklan')
@endif

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
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">@yield('title')</h2>
                <form action="{{ route('advertisement.update', $ads) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text"
                                            class="form-control @error('title')
                                                is-invalid
                                            @enderror"
                                            name="title" value="{{ $ads->title }}">
                                        @error('title')
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
                                            name="description">{!! $ads->description !!}</textarea>
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
                          @if($ads->image)
                          <img src="{{ asset($ads->image) }}" alt=""
                                        style="width:100%; max-height:300px; object-fit:cover; cursor:pointer"
                                        class="img-thumbnail" data-image="{{ asset($ads->image) }}"
                                        onerror="this.onerror=null; this.src='{{ asset('home2/assets/img/sample.png') }}';">
                                        @endif
                            <div class="card mt-2">
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label class="form-label">Photo / flyer</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            name="image">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="text-mutted mt-3">
                                            @if (app()->getLocale() == 'en')
                                                The photo or flyer to be displayed on the advertisement is square 300 x 300
                                                pixels, with a maximum size of 2 MB.
                                            @else
                                                Foto atau flyer yang akan ditampilkan pada iklan berbentuk persegi 300 x 300
                                                pixel, dengan ukuran maksimal 2 MB.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-save"></i> Submit</button>
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
