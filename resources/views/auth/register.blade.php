@extends('layouts.app')

@section('content')
    <div class="max-w-md bg-gray-200 mx-auto rounded-2xl px-4 py-6">
        <h3 class="text-center font-bold text-lg">Register</h3>
        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

{{--            <div class="space-y-2">--}}
{{--                <label for="username" class="">{{ __('Username') }}</label>--}}
{{--                <input--}}
{{--                    id="username"--}}
{{--                    type="text"--}}
{{--                    class="text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline--}}
{{--                    @error('username') is-invalid @enderror"--}}
{{--                    name="username"--}}
{{--                    value="{{ old('username') }}"--}}
{{--                    required--}}
{{--                    autocomplete="username"--}}
{{--                    autofocus--}}
{{--                >--}}
{{--            </div>--}}
{{--            @error('username')--}}
{{--            <div class="text-sm text-red-500">{{ $message }}</div>--}}
{{--            @enderror--}}

            <div class="space-y-2">
                <label for="name" class="">{{ __('Name') }}</label>
                <input
                    id="name"
                    type="text"
                    class="text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                    @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    autofocus
                >
            </div>
            @error('name')
            <div class="text-sm text-red-500">{{ $message }}</div>
            @enderror

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

            <div class="space-y-2">
                <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                <input
                    id="password-confirm"
                    type="password"
                    class="text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                    @error('password-confirm') is-invalid @enderror"
                    name="password_confirmation"
                    value="{{ old('password') }}"
                    required
                    autocomplete="password"
                    autofocus
                >
            </div>
            @error('password-confirm')
            <div class="text-sm text-red-500">{{ $message }}</div>
            @enderror

            <div class="text-center">
                <button
                    type="submit"
                    class="bg-blue-400 text-white rounded-full shadow px-6 py-3 mt-3 hover:bg-blue-500"
                >Register
                </button>
            </div>

            <div class="text-sm text-gray-800 text-center hover:underline mt-2">
                <a href="{{ route('login') }}">Already a user? Login...</a>
            </div>
        </form>
    </div>
@endsection
