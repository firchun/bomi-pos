<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Bomi POS</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="{{ asset('library/fontawesome/css/all.min.css') }}">

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Sidebar -->
            @include('components.sidebar')
            <!-- Header -->
            @include('components.header')
            <!-- Content -->
            @yield('main')
            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>
    @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
        <!-- Modal Upgrade to Pro -->
        <div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="upgradeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="upgradeModalLabel">Upgrade to Pro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>To access this feature, please upgrade your account to <strong>Pro</strong>. Enjoy
                            exclusive features, reports, and more!</p>
                        <p>Your current subscription status: <strong>Free</strong></p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('subscription.updatePro', auth()->id()) }}" method="POST">
                            @csrf
                            <input type="hidden" name="expired" class="form-control" required
                                value="{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                            <button type="submit" class="btn btn-primary">Upgrade Now</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Maybe
                            Later</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Modal Upgrade to Pro -->
        <div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="upgradeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="upgradeModalLabel">Pro Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>You are currently using a <strong>Pro</strong> account. Thank you for subscribing!</p>
                        <p>Enjoy full access to exclusive features, detailed reports, and premium support.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    
    @stack('scripts')
    
    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/page/components-table.js') }}"></script>
    @livewireScripts
</body>

</html>
