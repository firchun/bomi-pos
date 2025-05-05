@extends('layouts.auth')

@section('title', 'Reset Password')

@section('main')
<div class="max-w-md mx-auto mt-10 p-6 bg-white/70 dark:bg-zinc-800/70 shadow-md rounded-2xl">
    <h2 class="text-2xl font-bold text-center text-zinc-800 dark:text-white mb-4">
        Reset Password <span class="text-purple-600">Bomi POS</span>
    </h2>
    <p class="text-center text-sm text-zinc-500 dark:text-zinc-300 mb-6">
        Silakan isi password baru Anda
    </p>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email', $request->email) }}" required autofocus
                class="w-full px-4 py-2 mt-1 border border-zinc-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">New Password</label>
            <input type="password" id="password" name="password" required
                class="w-full px-4 py-2 mt-1 border border-zinc-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="w-full px-4 py-2 mt-1 border border-zinc-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white" />
        </div>

        <div>
            <button type="submit"
                class="w-full bg-purple-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-purple-700 transition duration-300">
                Reset Password
            </button>
        </div>
    </form>
</div>
@endsection