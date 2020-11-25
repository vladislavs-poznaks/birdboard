@extends('layouts.app')

@section('content')

    <div class="max-w-md bg-gray-200 mx-auto rounded-2xl px-4 py-6">
        <h3 class="text-center font-bold text-lg">Login</h3>
        <form method="POST" action="{{ route('login') }}" class="space-y-3">
            @csrf

            <div class="space-y-2">
                <label for="email" class="">{{ __('Email') }}</label>
                <input
                    id="email"
                    type="email"
                    class="text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                    @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                >
            </div>
            @error('email')
            <div class="text-sm text-red-500">{{ $message }}</div>
            @enderror

            <div class="space-y-2">
                <label for="password" class="">{{ __('Password') }}</label>
                <input
                    id="password"
                    type="password"
                    class="text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                    @error('password') is-invalid @enderror"
                    name="password"
                    value="{{ old('password') }}"
                    required
                    autocomplete="password"
                    autofocus
                >
            </div>
            @error('email')
            <div class="text-sm text-red-500">{{ $message }}</div>
            @enderror

            <div class="text-center">
                <button
                    type="submit"
                    class="bg-blue-400 text-white rounded-full shadow px-6 py-3 mt-3"
                >Login
                </button>
            </div>

            <div class="text-sm text-gray-800 text-center hover:underline mt-2">
                <a href="{{ route('register') }}">Sign Up</a>
            </div>
        </form>
    </div>
@endsection
