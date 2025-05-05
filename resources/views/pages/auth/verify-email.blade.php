@extends('layouts.auth')

@section('title', 'Verify Email')

@section('main')
<div class="max-w-md mx-auto mt-16 px-6 py-8 bg-white dark:bg-zinc-800 shadow-lg rounded-2xl border border-gray-200 dark:border-zinc-700">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white mt-2">Verify Your Email</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            Thanks for signing up! Please verify your email address by clicking the link we just sent to you.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center font-medium">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
        @csrf
        <button type="submit"
            class="w-full inline-flex justify-center items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
            Resend Verification Email
        </button>
    </form>

    <div class="text-center mt-6">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="text-sm text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400">
            Logout
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    </div>
</div>
@endsection