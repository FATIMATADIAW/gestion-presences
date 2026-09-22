<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScolPrésence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/presences') }}">ScolPrésence</a>
            <div class="navbar-nav">
                <a class="nav-link text-white" href="{{ url('/presences') }}">Séances</a>
                <a class="nav-link text-white" href="{{ url('/classes') }}">Classes</a>
                <a class="nav-link text-white" href="{{ url('/eleves') }}">Élèves</a>
            </div>
            <div class="d-flex align-items-center">
                @auth
                    <span class="text-white me-3">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Déconnexion</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
