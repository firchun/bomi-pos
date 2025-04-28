@php
    use App\Models\ShopProfile;
    use Illuminate\Support\Facades\Auth;

    $shopProfile = \App\Models\ShopProfile::where('user_id', Auth::id())->first();
@endphp

<!-- Sidebar -->
<div id="sidebar" class="text-white p-0" style="min-height: 100vh;">
    <!-- Bagian atas ungu -->
    <div class="p-3 text-center" style="background-color: #9900CC;">
        @if ($shopProfile && $shopProfile->photo)
            <img src="{{ asset('storage/' . $shopProfile->photo) }}" alt="Foto Toko" class="rounded-circle mb-2"
                style="width: 80px; height: 80px; object-fit: cover;">
        @else
            <img src="{{ asset('images/default-profile.png') }}" alt="Default Foto" class="rounded-circle mb-2"
                style="width: 80px; height: 80px; object-fit: cover;">
        @endif
        <strong class="text-white d-block mt-2">{{ Auth::user()->name }}</strong>
    </div>

    <!-- Bagian menu putih -->
    <div class="bg-white h-100 p-3">
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action"
                style="color: #9900CC !important; background-color: transparent !important; border-color: white !important;">
                <i class="fas fa-box me-2" style="color: #9900CC !important;"></i> Table
            </a>
            <a href="#" class="list-group-item list-group-item-action"
                style="color: #9900CC !important; background-color: transparent !important; border-color: white !important;">
                <i class="fas fa-cart-shopping me-2" style="color: #9900CC !important;"></i> Sales
            </a>
            <a href="#" class="list-group-item list-group-item-action"
                style="color: #9900CC !important; background-color: transparent !important; border-color: white !important;">
                <i class="fas fa-cog me-2" style="color: #9900CC !important;"></i> Setting
            </a>
        </div>
    </div>
</div>

<div id="overlay"></div>
