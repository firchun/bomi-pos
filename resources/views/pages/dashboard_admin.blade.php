@extends('layouts.app')

@section('title', 'Dashboard Admin')


@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/flag-icon-css/css/flag-icon.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
  </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.js') }}"></script>
    <script src="{{ asset('library/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index.js') }}"></script>

    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/index-0.js') }}"></script> --}}
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    {{-- chart js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
@endpush
