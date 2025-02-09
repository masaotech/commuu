<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- favicon --}}
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">

    {{-- meta tags --}}
    @isset($metaTags)
        {{ $metaTags }}
    @endisset
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg mb-12">
            {{ $slot }}
        </div>

        {{-- フラッシュメッセージ表示エリア --}}
        <div id="message_area" class="max-w-4xl fixed inset-0 top-20 mx-auto w-5/6 sm:w-1/2 h-1">
            @if (session('flash-message-info'))
                <x-flash-message-info :message="session('flash-message-info')" />
            @endif
            @if (session('flash-message-error'))
                <x-flash-message-error :message="session('flash-message-error')" />
            @endif
            @foreach ($errors->all() as $error)
                <x-flash-message-error :message="$error" />
            @endforeach
            @if (session('flash-message-success'))
                <x-flash-message-success :message="session('flash-message-success')" />
            @endif
        </div>
    </div>
</body>

</html>
