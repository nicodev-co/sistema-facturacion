<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('invoices.index','invoices.search') ? 'active' : ''}}" aria-current="page" href="/">Facturas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 card">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Nicodev-co') }}. All rights reserved.</p>
        </div>
    </footer>
    @stack('js')
</body>
</html>
