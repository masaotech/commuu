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

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- ナビゲーションバー --}}
        @include('layouts.navigation')

        {{-- ヘッダー --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-3 px-8 sm:px-12 lg:ps-20 lg:pe-24 flex justify-between">
                    <h2 class="font-semibold text-xl text-gray-700 leading-tight">
                        {{ $header }}
                    </h2>
                    @isset($settingLink)
                        {{ $settingLink }}
                    @endisset
                </div>
            </header>
        @endisset

        {{-- メインコンテンツ --}}
        <main class="pb-32">
            <div class="max-w-7xl mx-auto py-6 px-4 md:px-4 lg:px-8">
                {{ $slot }}
            </div>
        </main>

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

        {{-- フッター --}}
        @include('layouts.footer')
    </div>
</body>

</html>
