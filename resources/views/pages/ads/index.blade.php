@extends('layouts.app')
@if (app()->getLocale() == 'en')
    @section('title', 'Advertisement and promotion')
@else
    @section('title', 'Iklan dan Promosi')
@endif

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            @if ($ads->count() <= 2)
                <a href="{{ route('advertisement.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New
                    Advertisement</a>
                    @endif
                    <a href="{{ route('shop.details', $shop->slug) }}" class="btn btn-success "><i
                      class="fa fa-share"></i>
                  @if (app()->getLocale() == 'en')
                      Visit your page
                  @else
                      Kunjungi halamanmu
                  @endif
              </a>
            <p class="my-2 p-2 border rounded bg-light text-dark"> <i class="fa fa-circle-exclamation text-danger"></i>
                @if (app()->getLocale() == 'en')
                    Maximum advertisement and promotion is 3, if you want to add you can delete one of them
                @else
                    Maksimal iklan dan promosi berjumlah 3, jika ingin menambah anda bisa menghapus salah
                    satunya
                @endif
            </p>
          
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">

                    @foreach ($ads as $data)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>#{{ $loop->iteration }} {{ $data->title }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('advertisement.edit', $data->id) }}" class="btn btn-warning"><i
                                                class="fa fa-edit"></i> {{ __('general.edit') }}</a>
                                        <a href="{{ route('advertisement.destroy', $data->id) }}"
                                            onclick="event.preventDefault(); 
                                              if(confirm('Are you sure you want to delete this product?')) {
                                                  document.getElementById('delete-product-{{ $data->id }}').submit();
                                              }"
                                            class="btn btn-danger p-2"><i class="fa fa-trash"></i> </a>
                                        <form id="delete-product-{{ $data->id }}"
                                            action="{{ route('advertisement.destroy', $data->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">

                                    @if ($data->image)
                                        <img src="{{ asset($data->image) }}" alt=""
                                            style="width:100%; max-height:300px; object-fit:cover; cursor:pointer"
                                            class="img-thumbnail" data-toggle="modal" data-target="#imageModal"
                                            data-image="{{ asset($data->image) }}"
                                            onerror="this.onerror=null; this.src='{{ asset('home2/assets/img/sample.png') }}';">
                                    @else
                                        <span class="badge badge-danger">No Image</span>
                                    @endif
                                    <hr>
                                    <div><span class="h2 font-weight-bold text-primary">{{ $data->views }}</span>
                                        @if (app()->getLocale() == 'en')
                                            x Views
                                        @else
                                            x Dilihat
                                        @endif
                                    </div>
                                    <p>{!! Str::limit($data->description, 100) ?? '-' !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    </div>
    {{-- modal image --}}
    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modal-image" src="" alt="Preview" class="img-fluid rounded"
                        onerror="this.onerror=null; this.src='{{ asset('home2/assets/img/sample.png') }}';">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function fetchProducts(url = '{{ route('advertisement.index') }}') {
            const keyword = $('#search-input').val();
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    name: keyword
                },
                success: function(response) {
                    $('#product-table-wrapper').html(response);
                },
                error: function() {
                    alert('Failed to load data.');
                }
            });
        }

        $(document).ready(function() {
            let searchTimeout;

            $('#search-input').on('keyup', function() {
                clearTimeout(searchTimeout); // clear timeout sebelumnya
                searchTimeout = setTimeout(function() {
                    fetchProducts();
                }, 100);
            });

            // Pagination click (delegated)
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                fetchProducts(url);
            });

            // Modal image handler
            $('#imageModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var imageSrc = button.data('image');
                $(this).find('#modal-image').attr('src', imageSrc);
            });
        });
    </script>
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

)
