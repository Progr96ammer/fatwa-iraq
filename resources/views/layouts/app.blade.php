<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
        <style>body { font-family: 'Cairo', sans-serif; }</style>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/searchbuilder/1.8.2/css/searchBuilder.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/datetime/1.5.5/css/dataTables.dateTime.min.css" rel="stylesheet">


        <!-- Scripts -->
        @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('build/assets/app-DcsJ0mou.css') }}">
            <script src="{{ asset('build/assets/app-D_CSVirI.js') }}" defer></script>
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.8.2/js/dataTables.searchBuilder.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.8.2/js/searchBuilder.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.5/js/dataTables.dateTime.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.Echo) {
            window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
                .notification((notification) => {
                    alert(notification.message);
                    location.reload();
                });
        } else {
            console.error("Echo not initialized");
        }
    });
</script>
<script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                dom: 'Qlfrtip', // Q = SearchBuilder
                searchBuilder: {
                    columns: [0, 1, 2, 3]
                }
            });
        });
    </script>
</html>
