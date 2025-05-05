@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('main')
    <div class="max-w-md mx-auto mt-10 p-6 bg-white/70  dark:bg-zinc-800/70 shadow-md rounded-2xl">
        <h2 class="text-2xl font-bold text-center text-zinc-800 dark:text-white mb-4">
            Forgot Password <span class="text-purple-600">Bomi POS</span>
        </h2>
        <p class="text-center text-sm text-zinc-500 dark:text-zinc-300 mb-6">
          Please enter your registered email address to reset your password
        </p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Email"   class="mt-1 block w-full px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-2xl bg-white dark:bg-zinc-900 text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500" required />
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            <button type="submit" class=" mt-4 w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl font-semibold transition">Send Password Reset Link</button>
            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('login') }}" class="text-sm text-purple-600 hover:text-purple-500">Back to Sign In</a>
                <a href="{{ route('register') }}" class="text-sm text-purple-600 hover:text-purple-500">Create an Account</a>
            </div>
          </form>
        </div>
        @endsection
