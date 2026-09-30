<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScolPrésence - Plateforme de gestion des présences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --teal: #217a5f; --teal-dark: #175c45; --orange: #f97316; --ink: #1e293b; }
        body { font-family: 'Poppins', sans-serif; color: var(--ink); }

        .navbar { background: #fff; border-bottom: 1px solid #eef2f1; }
        .brand { font-weight: 700; color: var(--teal); font-size: 1.3rem; }
        .nav-link { color: #475569; font-weight: 500; }
        .nav-link:hover { color: var(--teal); }
        .btn-connect { background: var(--teal); color: #fff; border-radius: 30px; padding: 8px 22px; }
        .btn-connect:hover { background: var(--teal-dark); color: #fff; }

        .hero { background: linear-gradient(135deg, #eef6f2 0%, #f4f6f5 60%); padding: 70px 0 110px; overflow: visible; }
        .hero h1 { font-weight: 800; font-size: clamp(1.9rem, 4vw, 2.6rem); line-height: 1.25; color: var(--ink); }
        .hero h1 .accent { color: var(--orange); }
        .btn-orange { background: var(--orange); color: #fff; border-radius: 30px; padding: 10px 26px; font-weight: 600; }
        .btn-orange:hover { background: #ea580c; color: #fff; }
        .btn-outline-teal { border: 1.5px solid var(--teal); color: var(--teal); border-radius: 30px; padding: 10px 26px; font-weight: 600; }
        .btn-outline-teal:hover { background: var(--teal); color: #fff; }

        .illus-wrap { position: relative; padding: 30px; }
        .illus-photo { width: 100%; max-width: 420px; display: block; margin: 0 auto; filter: drop-shadow(0 25px 35px rgba(33,122,95,.25)); }
        .float-card { position: absolute; background: #fff; border-radius: 14px; padding: 10px 16px;
                      display: flex; align-items: center; gap: 10px; box-shadow: 0 12px 30px rgba(0,0,0,.15); font-size: .85rem; font-weight: 600; z-index: 2; }
        .float-card i { font-size: 1.2rem; }
        .fc1 { top: 10px; left: 0; color: var(--teal); }
        .fc2 { top: 40px; right: 0; color: var(--orange); }
        .fc3 { bottom: 40px; left: 10px; color: #2563eb; }
        .fc4 { bottom: 10px; right: 10px; color: #7c3aed; }

        .services { padding: 70px 0; }
        .service-card { border: 1px solid #eef2f1; border-radius: 16px; padding: 28px; height: 100%; transition: .2s; }
        .service-card:hover { box-shadow: 0 15px 35px rgba(33,122,95,.12); transform: translateY(-4px); }
        .service-ico { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center;
                       font-size: 1.5rem; color: #fff; margin-bottom: 16px; }

        footer { background: var(--ink); color: #cbd5e1; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top py-3">
    
    <div class="container">
        <a class="navbar-brand brand" href="/"><i class="bi bi-mortarboard-fill"></i> ScolPrésence</a>
        <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
           <ul class="navbar-nav mx-auto gap-lg-4">
    <li class="nav-item"><a class="nav-link" href="#accueil"><i class="bi bi-house-door"></i> Accueil</a></li>
    <li class="nav-item"><a class="nav-link" href="#services"><i class="bi bi-grid"></i> Fonctionnalités</a></li>
    <li class="nav-item"><a class="nav-link" href="#apropos"><i class="bi bi-info-circle"></i> À propos</a></li>
    <li class="nav-item"><a class="nav-link" href="#contact"><i class="bi bi-envelope"></i> Contact</a></li>
</ul>
            @auth
                <a href="{{ route('presences.index') }}" class="btn btn-connect">Mon espace</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-connect">Se connecter</a>
            @endauth
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="accueil">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1>Bienvenue sur  <br>l'application  de <span class="accent">gestion de présence d'un établissement</span>  scolaire</h1>
                <p class="text-muted my-4">
                    Découvrez une nouvelle façon de suivre l'assiduité : séances en ligne, pointage rapide,
                    statistiques et échanges simplifiés entre enseignants.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="btn btn-orange">Commencer maintenant <i class="bi bi-arrow-right"></i></a>
                    <a href="#services" class="btn btn-outline-teal"><i class="bi bi-play-circle"></i> Démonstration</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="illus-wrap">
                    <img src="{{ asset('images/etudiante.avif') }}" alt="Étudiante" class="illus-photo">

                    <div class="float-card fc1"><i class="bi bi-award-fill"></i> Excellence académique</div>
                    <div class="float-card fc2"><i class="bi bi-lightning-charge-fill"></i> Pointage instantané</div>
                    <div class="float-card fc3"><i class="bi bi-globe2"></i> Accès multiplateforme</div>
                    <div class="float-card fc4"><i class="bi bi-people-fill"></i> Communauté enseignante</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section class="services" id="services">
    <div class="container">
        <div class="text-center mb-5">
           <h2 class="fw-bold">Nos <span style="color:var(--teal)">fonctionnalités</span></h2>
            <p class="text-muted">Tout ce qu'il faut pour gérer les présences simplement.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="service-card">
                    <div class="service-ico" style="background:var(--teal)"><i class="bi bi-people-fill"></i></div>
                    <h6 class="fw-bold">Classes et élèves</h6>
                    <p class="text-muted small mb-0">Organisez vos classes et gérez chaque élève facilement.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="service-card">
                    <div class="service-ico" style="background:var(--orange)"><i class="bi bi-calendar-event-fill"></i></div>
                    <h6 class="fw-bold">Séances de cours</h6>
                    <p class="text-muted small mb-0">Planifiez vos séances par matière, date et heure.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="service-card">
                    <div class="service-ico" style="background:#2563eb"><i class="bi bi-check2-square"></i></div>
                    <h6 class="fw-bold">Pointage rapide</h6>
                    <p class="text-muted small mb-0">Présent, absent ou en retard, en un clic.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="service-card">
                    <div class="service-ico" style="background:#7c3aed"><i class="bi bi-graph-up-arrow"></i></div>
                    <h6 class="fw-bold">Statistiques</h6>
                    <p class="text-muted small mb-0">Suivez l'assiduité de chaque classe en temps réel.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- À PROPOS -->
<section class="py-5 bg-light" id="apropos">
    <div class="container text-center py-4">
        <h2 class="fw-bold mb-3">À <span style="color:var(--teal)">propos</span></h2>
        <p class="text-muted mx-auto" style="max-width:700px;">
            ScolPrésence est une application développée dans le cadre d'un projet de soutenance,
            pour remplacer les registres papier par un suivi numérique fiable et accessible aux enseignants.
        </p>
    </div>
</section>

<!-- CONTACT / FOOTER -->
<footer class="py-5" id="contact">
    <div class="container text-center">
        <h5 class="text-white"><i class="bi bi-mortarboard-fill"></i> ScolPrésence</h5>
        <p class="mb-1"><i class="bi bi-envelope"></i> contact@scolpresence.sn</p>
        <p class="mb-3"><i class="bi bi-geo-alt"></i> Thiès, Sénégal</p>
        <small>&copy; {{ date('Y') }} ScolPrésence. Tous droits réservés.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>