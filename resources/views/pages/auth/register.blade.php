@extends('layouts.auth')

@section('title', 'Sign Up')

@section('main')
    <div class="bg-white/70 dark:bg-zinc-800/70 shadow-md rounded-2xl px-8 py-6 mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center text-zinc-800 dark:text-white">Sign Up to Manage Your Business</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-1 dark:text-gray-200">Name</label>
                <input id="name" type="text" name="name"
                    class="w-full px-4 py-2 rounded-2xl border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    value="{{ old('name') }}" autofocus>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Business Name -->
            <div class="mb-4">
                <label for="business_name" class="block text-sm font-medium mb-1 dark:text-gray-200">Business Name</label>
                <input id="business_name" type="text" name="business_name"
                    class="w-full px-4 py-2 rounded-2xl border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    value="{{ old('business_name') }}">
                @error('business_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-1 dark:text-gray-200">Email</label>
                <input id="email" type="email" name="email"
                    class="w-full px-4 py-2 rounded-2xl border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1 dark:text-gray-200">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password"
                        class="w-full px-4 py-2 pr-10 rounded-2xl border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-600 dark:text-gray-300">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium mb-1 dark:text-gray-200">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="w-full px-4 py-2 rounded-2xl border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-2xl hover:bg-purple-700 transition">
                    Sign Up
                </button>
            </div>
        </form>
    </div>

    <div class="text-center mt-4 text-sm text-gray-600 dark:text-gray-300">
        Already have an account? <a href="{{ route('login') }}" class="text-primary hover:underline">Sign In Now</a>
    </div>
@endsection

@push('scripts')
    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const icon = toggleBtn.querySelector('i');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
@endpush