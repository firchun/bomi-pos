@extends('layouts.app')

@section('title', $title)

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fa fa-gear"></i> @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            <div class="section-body">

                <button class="btn btn-primary btn-lg mb-3" data-toggle="modal" data-target="#generateModal">
                    <i class="fa fa-plus"></i> {{ __('general.add') }} {{ __('general.Tables') }}
                </button>
                <a class="btn btn-danger btn-lg mb-3" href="{{ route('tables.print') }}" target="_blank">
                    <i class="fa fa-print"></i> {{ __('general.print') }} {{ __('general.Tables') }}
                </a>

                <div class="row" id="table-container">
                    @foreach ($tables as $table)
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card bg-primary text-white" style="border-radius:10px;">
                                <div class="card-body text-center">

                                    <h5 class="mb-0">{{ $table->name }}</h5>
                                    <img src="{{ asset('img/table-icon.png') }}" alt="Table Image" class="img-fluid m-2"
                                        style="max-width: 100px;">
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="{{ route('shop.table', $table->code) }}" target="_blank"
                                            class="btn btn-light btn-sm me-2">
                                            {{ __('general.Open') }}
                                        </a>
                                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> {{ __('general.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="generateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('general.add') }} {{ __('general.Tables') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="generate-form">
                        @csrf
                        <div class="form-group">
                            <label for="jumlah">Jumlah Meja</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" required
                                min="1">
                        </div>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script>
        $('#generate-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('tables.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    $('#generateModal').modal('hide');
                    $('#jumlah').val('');
                    // Refresh UI meja tanpa reload
                    $('#table-container').html('');
                    res.tables.forEach(function(table) {
                        $('#table-container').append(`
                          <div class="col-md-3 col-sm-6 mb-3">
                              <a href="/shop/table/${table.code}" target="__blank" style="text-decoration: none;">
                                 <div class="card bg-primary" style="border-radius:20px;">
                                      <div class="card-body text-center">
                                          <h5>${table.name}</h5>
                                      </div>
                                  </div>
                              </a>
                          </div>
                      `);
                    });
                }
            });
        });
    </script>
@endpush
