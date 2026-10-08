<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Accueil') - ScolPrésence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ===== PALETTE : modifie les couleurs ICI, tout le site suit ===== */
        :root {
            --sidebar-dark: #1b5e4a;
            --sidebar-darker: #14432f;
            --sidebar-text: #cfe6da;
            --primary: #1f7a5f;
            --primary-dark: #16624a;
            --accent: #f5a623;
            --accent-dark: #e0951a;
            --accent-shadow: rgba(245, 166, 35, 0.35);
            --primary-shadow: rgba(31, 122, 95, 0.2);
            --on-accent: #3a2a05;
            --info: #2563eb;
            --info-dark: #1d4ed8;
            --danger: #e53935;
            --danger-dark: #c62828;
            --row-hover: #eef7f2;
            --text: #1f2937;
            --bg: #f4f6f7;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, var(--sidebar-dark), var(--sidebar-darker));
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            padding: 1.2rem 0.9rem;
            flex-shrink: 0;
            min-height: 100vh;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-weight: 700;
            font-size: 1.05rem;
            color: #fff;
            margin-bottom: 1.6rem;
            text-decoration: none;
        }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: var(--accent); }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.92rem;
            margin-bottom: 0.25rem;
            transition: background .15s;
        }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.16); color: #fff; font-weight: 600; }
        .sidebar-footer { margin-top: auto; }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 600;
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 0.6rem 0.8rem;
            margin-bottom: 0.7rem;
        }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: var(--accent);
            color: var(--on-accent);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .btn-logout {
            display: block;
            width: 100%;
            background: var(--accent);
            color: var(--on-accent);
            border: none;
            padding: 0.7rem;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
        }
        .btn-logout:hover { background: var(--accent-dark); }
        .main-content { flex: 1; padding: 2rem 2.4rem; min-width: 0; }

        /* ===== STYLES COMMUNS DES PAGES (Séances, Classes, Élèves...) ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.6rem;
        }
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin: 0;
        }
        .page-title .bar {
            width: 5px; height: 26px;
            background: var(--accent);
            border-radius: 3px;
        }
        .btn-add {
            background: var(--accent);
            color: var(--on-accent);
            border: none;
            padding: 0.65rem 1.2rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            box-shadow: 0 4px 10px var(--accent-shadow);
            transition: transform .15s;
        }
        .btn-add:hover { transform: translateY(-1px); background: var(--accent-dark); color: var(--on-accent); }

        .table-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            border: none;
        }
        .table-card thead th {
            background: linear-gradient(90deg, var(--primary), var(--primary-dark)) !important;
            color: #fff !important;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            border: none;
            padding: 1.1rem 1.5rem;
        }
        .table-card tbody td {
            font-size: 1rem;
            padding: 1.1rem 1.5rem;
            vertical-align: middle;
        }
        .table-card tbody tr:hover { background: var(--row-hover); }
        .table-card .btn-sm { font-size: 0.85rem; padding: 0.5rem 1rem; }

        .badge-classe {
            display: inline-block;
            background: var(--primary);
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
        }
        .btn-pointer { background: var(--info); border-color: var(--info); }
        .btn-supprimer { background: var(--danger); border-color: var(--danger); }

        /* Sans ces règles, Bootstrap rend le fond transparent au survol/clic
           et le texte blanc disparaît */
        .btn.btn-pointer:hover,
        .btn.btn-pointer:focus,
        .btn.btn-pointer:active {
            background: var(--info-dark);
            border-color: var(--info-dark);
            color: #fff;
        }
        .btn.btn-supprimer:hover,
        .btn.btn-supprimer:focus,
        .btn.btn-supprimer:active {
            background: var(--danger-dark);
            border-color: var(--danger-dark);
            color: #fff;
        }

        /* ===== FORMULAIRES & PAGES DE DÉTAIL ===== */
        .btn-add { cursor: pointer; display: inline-block; }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 1rem;
        }
        .back-link:hover { color: var(--primary-dark); }
        .form-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 2rem;
            max-width: 640px;
        }
        .form-card .form-label { font-weight: 600; }
        .form-card .form-control,
        .form-card .form-select { border-radius: 8px; padding: 0.65rem 0.9rem; }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem var(--primary-shadow);
        }
        .form-actions { display: flex; gap: 0.7rem; align-items: center; margin-top: 1.5rem; }
        .btn-cancel {
            color: var(--text);
            background: #eef0f2;
            border-radius: 8px;
            padding: 0.65rem 1.2rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .btn-cancel:hover { background: #e2e5e8; color: var(--text); }
        .meta-chip {
            display: inline-block;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.9rem;
            margin-right: 0.4rem;
        }

        /* ===== MOBILE : barre du haut + menu qui s'ouvre au clic ===== */
        .mobile-bar, .sidebar-overlay { display: none; }

        @media (max-width: 768px) {
            body { display: block; }

            .mobile-bar {
                display: flex;
                align-items: center;
                gap: 0.8rem;
                position: fixed;
                top: 0; left: 0; right: 0;
                height: 56px;
                padding: 0 1rem;
                background: var(--sidebar-dark);
                color: #fff;
                font-weight: 700;
                z-index: 1030;
            }
            .menu-toggle {
                background: rgba(255,255,255,0.12);
                color: #fff;
                border: none;
                border-radius: 8px;
                width: 40px; height: 40px;
                font-size: 1.4rem;
                line-height: 1;
                cursor: pointer;
            }

            .sidebar {
                position: fixed;
                top: 0; left: 0; bottom: 0;
                width: 250px;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform .25s ease;
                overflow-y: auto;
            }
            body.menu-open .sidebar { transform: translateX(0); }
            body.menu-open .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.45);
                z-index: 1040;
            }

            .main-content { padding: 4.6rem 1rem 1.5rem; }

            .page-header { flex-wrap: wrap; gap: 0.8rem; }
            .page-title { font-size: 1.25rem; }

            .table-card thead th,
            .table-card tbody td { padding: 0.8rem 0.9rem; font-size: 0.9rem; }
            .table-card .btn-sm { padding: 0.4rem 0.7rem; font-size: 0.8rem; }

            .form-card { padding: 1.2rem; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="mobile-bar">
        <button type="button" class="menu-toggle" id="menuToggle" aria-label="Ouvrir le menu">☰</button>
        <span>ScolPrésence</span>
    </div>
    <div class="sidebar-overlay" id="menuOverlay"></div>

    <aside class="sidebar">
        <a class="brand" href="{{ url('/presences') }}"><span class="dot"></span> ScolPrésence</a>

        <a class="nav-item {{ request()->is('presences*') ? 'active' : '' }}" href="{{ url('/presences') }}">
            📅 Séances
        </a>
        <a class="nav-item {{ request()->is('classes*') ? 'active' : '' }}" href="{{ url('/classes') }}">
            🏫 Classes
        </a>
        <a class="nav-item {{ request()->is('eleves*') ? 'active' : '' }}" href="{{ url('/eleves') }}">
            👥 Élèves
        </a>
        <a class="nav-item {{ request()->is('absences*') ? 'active' : '' }}" href="{{ route('absences.index') }}">
            📝 Absences
        </a>
        <a class="nav-item {{ request()->is('stats*') ? 'active' : '' }}" href="{{ route('stats.index') }}">
            📊 Statistiques
        </a>

        <div class="sidebar-footer">
            @auth
                <div class="sidebar-user">
                    <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    {{ auth()->user()->name }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Déconnexion</button>
                </form>
            @endauth
        </div>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {
            var toggle = document.getElementById('menuToggle');
            var overlay = document.getElementById('menuOverlay');
            if (!toggle || !overlay) return;
            toggle.addEventListener('click', function () {
                document.body.classList.toggle('menu-open');
            });
            overlay.addEventListener('click', function () {
                document.body.classList.remove('menu-open');
            });
        })();
    </script>

    {{-- Les scripts des pages (graphiques...) doivent se charger APRÈS le HTML --}}
    @stack('scripts')
</body>
</html>