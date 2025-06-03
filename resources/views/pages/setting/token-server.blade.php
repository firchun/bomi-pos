@extends('layouts.app')

@section('title', 'Generate Server Token')

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

            <div class="section-body">
                <h2 class="section-title">@yield('title')</h2>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="text-center mb-4">
                            <button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                data-target="#tokenModal">
                                @if ($server)
                                    <i class="fa fa-edit"></i>
                                    Update
                                @else
                                    <i class="fa fa-plus"></i>
                                    Generate New
                                @endif
                                Token
                            </button>
                        </div>
                        <div class="card rounded">
                            <div class="card-body">
                                @if ($server)
                                    <ul class="list-group list-group-flush shadow-sm rounded border">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong><i class="fa fa-server mr-2 text-primary"></i> Nama Server:</strong>
                                            <span>{{ $server->name_server }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong><i class="fa fa-map-marker-alt mr-2 text-danger"></i> Lokasi
                                                Server:</strong>
                                            <span>{{ $server->address_server }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong><i class="fa fa-phone mr-2 text-success"></i> Telepon:</strong>
                                            <span>{{ $server->phone ?? '-' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong><i class="fa fa-key mr-2 text-warning"></i> Token:</strong>
                                            <code class="text-monospace text-break">{{ $server->token }}</code>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong><i class="fa fa-signal mr-2 text-info"></i> Status:</strong>
                                            @if ($server->active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Nonaktif</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong><i class="fa fa-calendar-alt mr-2 text-muted"></i> Dibuat pada:</strong>
                                            <span>{{ $server->created_at->format('d-m-Y H:i') }}</span>
                                        </li>
                                    </ul>
                                @else
                                    <p class="text-center text-muted">Anda belum mempunyai server token</p>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="card">
                            <div class="card-body">
                                <ul class="list-group list-group-flush shadow-sm rounded border">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong><i class="fa fa-server mr-2 text-primary"></i> Singkriniasi:</strong>
                                        <span>{{ $server->created_at->format('d-m-Y H:i') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong><i class="fa fa-server mr-2 text-primary"></i> Singkriniasi:</strong>
                                        <span>{{ $server->created_at->format('d-m-Y H:i') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-labelledby="tokenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="tokenForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generate New Server Token</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name_server">Nama Server</label>
                            <input type="text" class="form-control" name="name_server" id="name_server"
                                value="{{ $server->name_server ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address_server">Alamat Server</label>
                            <input type="text" class="form-control" name="address_server" id="address_server"
                                value="{{ $server->address_server ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telepon (Opsional)</label>
                            <input type="text" class="form-control" name="phone" id="phone"
                                value="{{ $server->phone ?? '' }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script>
        document.getElementById('tokenForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = new FormData(this);
            const response = await fetch("{{ route('generate-token') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: form
            });

            const data = await response.json();

            if (response.ok) {
                $('#tokenModal').modal('hide');
                this.reset();
                location.reload();


            } else {
                alert(data.message || 'Gagal menyimpan token');
            }

        });
    </script>
@endpush
