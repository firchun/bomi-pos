@extends('layouts.app')

@section('title', 'User Accounts')

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
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">@yield('title')</h2>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('users.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <tr>
                                        <th>Name</th>
                                        <th>Name Outlet</th>
                                        <th>Regiester at</th>
                                        <th>Cashier</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($users as $user)
                                        @php
                                            $user->business_name = $user->business_name ?? 'No Outlet';

                                            $shop = App\Models\ShopProfile::where('user_id', $user->id)->first();

                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $user->name }}</strong><br>
                                                <small>Email : <a
                                                        href="mailto:{{ $user->email }}">{{ $user->email }}</a></small>
                                            </td>
                                            <td>
                                                <strong
                                                    class="text-primary">{{ $shop ? $shop->name : $user->business_name }}</strong>
                                                @if ($shop)
                                                    <br> <a href="{{ route('shop.details', $shop->slug) }}"
                                                        target="__blank">{{ $shop->address }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}<br>
                                                @if ($user->email_verified_at)
                                                    <small class="text-mutted">Verified at
                                                        {{ \Carbon\Carbon::parse($user->email_verified_at)->translatedFormat('d F Y') }}</small>
                                                @else
                                                    <small class="text-danger">Not Verified</small>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary"><i
                                                        class="fa fa-users"></i> Cashier</button>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-start">
                                                    <button type="button" class="btn btn-sm btn-primary btn-icon"
                                                        data-toggle="modal" data-target="#emailModal-{{ $user->id }}">
                                                        <i class="fas fa-envelope"></i> Mail
                                                    </button>
                                                    @if (Auth::user()->role == 'admin')
                                                        <a href='{{ route('users.edit', $user->id) }}'
                                                            class="btn btn-sm btn-info btn-icon ml-2">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $users->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @foreach ($users as $user)
        <!-- Modal Email -->
        <div class="modal fade" id="emailModal-{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="emailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="email">Kepada</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subjek</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Pesan</label>
                                <textarea class="form-control" id="message" name="message" rows="10" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
