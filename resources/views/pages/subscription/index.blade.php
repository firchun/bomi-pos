@extends('layouts.app')
@section('title', 'Subscription')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Subscription</a></div>
                    <div class="breadcrumb-item">Subscription</div>
                </div>
            </div>

            <div class="section-body">
                <div class="container">
                    <h4 class="mb-4">Subscription Management</h4>

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('subscription.update') }}" method="POST">
                                @csrf

                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Subscribed?</th>
                                            <th>Expiration Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <input type="checkbox"
                                                        name="subscriptions[{{ $user->id }}][subscribed]"
                                                        {{ $user->is_subscribed ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="date" name="subscriptions[{{ $user->id }}][expired]"
                                                        value="{{ $user->subscription_expires_at ? \Carbon\Carbon::parse($user->subscription_expires_at)->format('Y-m-d') : '' }}"
                                                        class="form-control">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary">Update Subscription</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
