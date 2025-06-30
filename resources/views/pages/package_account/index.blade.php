@extends('layouts.app')

@section('title', 'Manage Package Account')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('library/fullcalendar/dist/fullcalendar.min.css') }}"> --}}
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Blogs</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">@yield('title')</h2>
                <div class="mb-3">
                    <a href="{{ route('packages-account.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Package
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name & Type</th>
                                    <th>Price</th>
                                    <th>Features</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($package_account as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>



                                        <td>
                                            <strong>{{ $item->name }}</strong><br>
                                            @if ($item->type)
                                                <span class="badge badge-success">{{ $item->type }}</span>
                                            @endif
                                        </td>

                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>

                                        <td>
                                            <ul class="pl-3 mb-0">
                                                @foreach ($item->features as $feature)
                                                    <li>{{ $feature }}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        <td>
                                            <a href="{{ route('packages-account.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('packages-account.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this package?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No package account found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name & Type</th>
                                    <th>Price</th>
                                    <th>Features</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="{{ asset('library/fullcalendar/dist/fullcalendar.min.js') }}"></script> --}}
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-calendar.js') }}"></script>
    <!-- JS FullCalendar (v5+) -->
@endpush
