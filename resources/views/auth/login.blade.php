<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ScolPrésence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --teal: #217a5f; --teal-dark: #175c45; --teal-deep: #14503c; }

        body { font-family: 'Poppins', sans-serif; background: #f4f6f5; min-height: 100vh; min-height: 100dvh;
               display: flex; align-items: center; justify-content: center; padding: 20px; }

        .login-card { max-width: 950px; width: 100%; background: #fff; border-radius: 20px; overflow: hidden;
                      box-shadow: 0 20px 50px rgba(0,0,0,.1); }

        /* ---------- Panneau vert (ordinateur / tablette) ---------- */
        .left { background: linear-gradient(135deg, var(--teal) 0%, var(--teal-deep) 100%); color: #fff;
                display: flex; align-items: center; justify-content: center; padding: 40px; position: relative; min-height: 440px; }
        .left::before { content:''; position:absolute; width:240px; height:240px; border-radius:50%;
                        background: rgba(255,255,255,.08); top:-60px; left:-60px; }
        .left::after { content:''; position:absolute; width:200px; height:200px; border-radius:50%;
                       background: rgba(255,255,255,.08); bottom:-50px; right:-50px; }
        .left-content { position: relative; z-index: 1; text-align: center; }
        .left-content i { font-size: 3.5rem; margin-bottom: 16px; }

        /* ---------- Bandeau vert (mobile uniquement) ---------- */
        .mobile-brand { background: linear-gradient(135deg, var(--teal) 0%, var(--teal-deep) 100%); color: #fff;
                        padding: 22px 16px; text-align: center; }
        .mobile-brand i { font-size: 2rem; }
        .mobile-brand h4 { margin: 6px 0 0; font-size: 1.25rem; }

        /* ---------- Formulaire ---------- */
        .right { padding: 45px 40px; }
        .input-group-text { background: #f1f5f9; border: 1px solid #e2e8f0; color: var(--teal); }
        .form-control { background: #f1f5f9; border: 1px solid #e2e8f0; padding: 11px; }
        .form-control:focus { box-shadow: 0 0 0 .2rem rgba(33,122,95,.2); border-color: var(--teal); }
        .btn-login { background: var(--teal); color: #fff; padding: 11px; border-radius: 10px; font-weight: 600; }
        .btn-login:hover { background: var(--teal-dark); color: #fff; }
        .toggle-pass { cursor: pointer; }
        .lien-teal { color: var(--teal); font-weight: 600; text-decoration: none; }

        /* ---------- Choix du rôle ---------- */
        .role-choice { display: flex; gap: 8px; margin-bottom: 18px; }
        /* masqué visuellement mais toujours accessible au clavier */
        .role-choice input { position: absolute; opacity: 0; pointer-events: none; }
        .role-choice label { flex: 1; text-align: center; padding: 10px 4px; border: 1px solid #e2e8f0;
                             border-radius: 10px; cursor: pointer; font-size: .85rem; font-weight: 500; background: #f1f5f9; }
        .role-choice label:hover { border-color: var(--teal); }
        .role-choice input:checked + label { background: var(--teal); color: #fff; border-color: var(--teal); }
        .role-choice input:focus-visible + label { outline: 3px solid rgba(33,122,95,.4); outline-offset: 2px; }

        /* =========================================================
           RESPONSIVE
           ========================================================= */

        /* Tablette : on réduit les marges */
        @media (max-width: 991.98px) {
            .left { padding: 28px 20px; }
            .right { padding: 36px 28px; }
        }

        /* Mobile : une seule colonne, carte pleine largeur */
        @media (max-width: 767.98px) {
            body { align-items: flex-start; padding: 0; }
            .login-card { border-radius: 0; box-shadow: none; min-height: 100vh; min-height: 100dvh; }
            .right { padding: 24px 18px 32px; }

            .role-choice { gap: 6px; }
            .role-choice label { padding: 10px 2px; font-size: .78rem; }
            .role-choice label i { display: block; font-size: 1.1rem; margin-bottom: 2px; }

            /* 16px minimum : évite le zoom automatique sur iPhone */
            .form-control { font-size: 16px; }
        }

        /* Très petits écrans (320 px) */
        @media (max-width: 359.98px) {
            .right { padding: 20px 12px 28px; }
            .role-choice label { font-size: .72rem; }
        }

        /* Téléphone en paysage */
        @media (max-height: 520px) and (orientation: landscape) {
            body { align-items: flex-start; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- Bandeau mobile -->
    <div class="mobile-brand d-md-none">
        <i class="bi bi-mortarboard-fill"></i>
        <h4 class="fw-bold">ScolPrésence</h4>
    </div>

    <div class="row g-0">

        <!-- Colonne gauche (cachée sur mobile) -->
        <div class="col-md-6 d-none d-md-flex left">
            <div class="left-content">
                <i class="bi bi-mortarboard-fill"></i>
                <h4 class="fw-bold">ScolPrésence</h4>
                <p class="small opacity-75 mb-0">Plateforme de gestion des présences pour un suivi simple et fiable de vos élèves.</p>
            </div>
        </div>

        <!-- Colonne droite -->
        <div class="col-12 col-md-6 right">
            <div class="text-center mb-4">
                <i class="bi bi-mortarboard-fill fs-1 d-none d-md-inline-block" style="color: var(--teal)"></i>
                <h4 class="fw-bold mt-2">Connexion à votre compte</h4>
                <p class="text-muted small">Choisissez votre profil puis entrez vos identifiants</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="role-choice">
                    <input type="radio" name="role" id="role-enseignant" value="enseignant"
                           {{ old('role', 'enseignant') === 'enseignant' ? 'checked' : '' }}>
                    <label for="role-enseignant"><i class="bi bi-person-workspace"></i> Professeur</label>

                    <input type="radio" name="role" id="role-admin" value="admin"
                           {{ old('role') === 'admin' ? 'checked' : '' }}>
                    <label for="role-admin"><i class="bi bi-shield-lock"></i> Admin</label>

                    <input type="radio" name="role" id="role-eleve" value="eleve"
                           {{ old('role') === 'eleve' ? 'checked' : '' }}>
                    <label for="role-eleve"><i class="bi bi-mortarboard"></i> Élève</label>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                           placeholder="Adresse e-mail" autocomplete="email" required>
                </div>

                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Mot de passe" autocomplete="current-password" required>
                    <span class="input-group-text toggle-pass" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eye"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Se connecter
                </button>
            </form>

            <div class="text-center mt-4 small">
                Pas encore de compte ? <a href="{{ route('register') }}" class="lien-teal">Créer un compte</a>
            </div>
            <div class="text-center mt-2">
                <a href="{{ url('/') }}" class="small text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const eye = document.getElementById('eye');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        eye.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    }
</script>
</body>
</html>