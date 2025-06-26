@extends('layouts.auth')

@section('title', 'Sign In')

@section('main')
    <div class="max-w-md mx-auto mt-10 p-6 bg-white/70  dark:bg-zinc-800/70 shadow-md rounded-2xl">
        <h2 class="text-2xl font-bold text-center text-zinc-800 dark:text-white mb-4">
            Sign in <span class="text-purple-600">Bomi POS</span>
            @if (App::environment('local'))
                <span class="py-[1px] px-[5px] bg-red-600 text-white rounded">Local</span>
            @endif
        </h2>
        <p class="text-center text-sm text-zinc-500 dark:text-zinc-300 mb-6">
            Please Sign In first
        </p>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Email</label>
                <input type="email" name="email" id="email"
                    class="mt-1 block w-full px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-2xl bg-white dark:bg-zinc-900 text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between">
                    <label for="password"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Password</label>
                    <a href="{{ route('password.request') }}"
                        class="block text-sm font-medium text-purple-700  hover:underline">Forgot Password</a>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full px-4 py-2 pr-10 border border-zinc-300 dark:border-zinc-700 rounded-2xl bg-white dark:bg-zinc-900 text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                        required>
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-2 flex items-center text-zinc-500 dark:text-zinc-300">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember"
                    class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                    {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="ml-2 block text-sm text-zinc-700 dark:text-zinc-300">
                    Remember Me
                </label>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl font-semibold transition">
                    Sign In
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-zinc-600 dark:text-zinc-300">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-purple-600 hover:underline">Sign Up Now</a>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
@endpush
