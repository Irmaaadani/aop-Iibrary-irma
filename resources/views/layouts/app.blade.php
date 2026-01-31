<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>@yield('title', 'Perpustakaan')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar {
            width: 220px;
            transition: width 0.3s;
        }

        .sidebar-collapsed .sidebar {
            width: 70px;
        }

        .sidebar-collapsed .sidebar .sidebar-text {
            display: none;
        }
    </style>
</head>
<body>

<div id="appLayout" class="d-flex" style="min-height: 100vh;">

    @include('layouts.sidebar')

    <div class="flex-fill p-4 bg-light">

        <button class="btn btn-outline-secondary btn-sm mb-3"
                onclick="toggleSidebar()">
            ☰
        </button>

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    
function toggleSidebar() {
    document.getElementById('appLayout')
        .classList.toggle('sidebar-collapsed');
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
