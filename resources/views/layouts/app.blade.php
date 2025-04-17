<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="{{ url('/') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Room Booking System' }}</title>

    {{-- favicon --}}
    {{-- <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon"> --}}

    {{-- Scripts --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body id="body">
    @auth
        @include('commun.header')
        @include('commun.toast')
        @include('commun.menu')
    @endauth

    <main>
        <div class="height-100 bg-light">
            {{ $slot }}
        </div>
    </main>

    @yield('scripts')
</body>
</html>
