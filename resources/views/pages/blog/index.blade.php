@extends('layouts.app')

@section('title', 'Blogs')

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
                    <a href="{{ route('admin-blogs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Blog
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blogs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('blog-detail', $item->slug) }}" target="__blank">
                                                {{ $item->title }}</a>
                                            <br><small class="text-mutted">{{ $item->views }} View</small>
                                        </td>
                                        <td><img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                                class="rounded-circle mr-1"
                                                style="width: 20px; height:20px;">{{ $item->user->name }}</td>
                                        <td>
                                            <small
                                                class="badge badge-{{ $item->is_published == 1 ? 'primary' : 'warning' }}">{{ $item->is_published == 1 ? 'Publihed' : 'Draft' }}</small>
                                            <br>{{ $item->created_at->format('d M Y') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin-blogs.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin-blogs.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No blogs available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Date</th>
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
