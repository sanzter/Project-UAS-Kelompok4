<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpsonv - @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-slate-50">
<div class="min-h-screen flex">
    @include('layouts.partials.sidebar')
    <div class="flex-1 flex flex-col overflow-hidden">
        @include('layouts.partials.header')
        <main class="p-10 flex-1 overflow-y-auto bg-slate-50">
            @yield('dashboard-content')
        </main>
    </div>
</div>
<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>