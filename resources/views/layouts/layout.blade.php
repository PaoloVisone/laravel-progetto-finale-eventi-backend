<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>

    @vite('resources/js/app.js')
</head>
<body>
     <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Event Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                     <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('events.*')) active @endif" 
                       href="{{ route('events.index') }}">
                        Eventi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('bookings.*')) active @endif" 
                       href="{{ route('bookings.index') }}">
                       Prenotazioni
                    </a>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="content">
            <h1 class="mb-4">
                @yield("title")
            </h1>

            @yield("content")
        </div>
    </div>

    <!-- Footer-->
    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Event Manager</p>
        </div>
    </footer>
</body>
</html>