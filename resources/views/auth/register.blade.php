<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - ScolPrésence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --teal: #217a5f; --teal-dark: #175c45; --teal-deep: #14503c; }
        body { font-family: 'Poppins', sans-serif; background: #f4f6f5; min-height: 100vh;
               display: flex; align-items: center; justify-content: center; padding: 20px; }
        .login-card { max-width: 950px; width: 100%; background: #fff; border-radius: 20px; overflow: hidden;
                      box-shadow: 0 20px 50px rgba(0,0,0,.1); }
        .left { background: linear-gradient(135deg, var(--teal) 0%, var(--teal-deep) 100%); color: #fff;
                display: flex; align-items: center; justify-content: center; padding: 40px; position: relative; min-height: 520px; }
        .left::before { content:''; position:absolute; width:240px; height:240px; border-radius:50%;
                        background: rgba(255,255,255,.08); top:-60px; left:-60px; }
        .left::after { content:''; position:absolute; width:200px; height:200px; border-radius:50%;
                       background: rgba(255,255,255,.08); bottom:-50px; right:-50px; }
        .left-content { position: relative; z-index: 1; text-align: center; }
        .left-content i { font-size: 3.5rem; margin-bottom: 16px; }
        .right { padding: 40px; }
        .input-group-text { background: #f1f5f9; border: 1px solid #e2e8f0; color: var(--teal); }
        .form-control { background: #f1f5f9; border: 1px solid #e2e8f0; padding: 11px; }
        .form-control:focus { box-shadow: 0 0 0 .2rem rgba(33,122,95,.2); border-color: var(--teal); }
        .btn-login { background: var(--teal); color: #fff; padding: 11px; border-radius: 10px; font-weight: 600; }
        .btn-login:hover { background: var(--teal-dark); color: #fff; }
        .toggle-pass { cursor: pointer; }
        .lien-teal { color: var(--teal); font-weight: 600; text-decoration: none; }

        @media (max-width: 768px) {
            body { align-items: flex-start; padding: 12px; }
            .right { padding: 24px 18px; }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="row g-0">

        <!-- Colonne gauche -->
        <div class="col-md-6 d-none d-md-flex left">
            <div class="left-content">
                <i class="bi bi-mortarboard-fill"></i>
                <h4 class="fw-bold">ScolPrésence</h4>
                <p class="small opacity-75 mb-0">Créez votre compte enseignant pour pointer vos séances et suivre l'assiduité de vos classes.</p>
            </div>
        </div>

        <!-- Colonne droite -->
        <div class="col-md-6 right">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill fs-1" style="color: var(--teal)"></i>
                <h4 class="fw-bold mt-2">Créer un compte</h4>
                <p class="text-muted small">Renseignez vos informations pour accéder à votre espace</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                           placeholder="Nom complet" required autofocus>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                           placeholder="Adresse e-mail" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Mot de passe (6 caractères minimum)" required>
                    <span class="input-group-text toggle-pass" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eye"></i>
                    </span>
                </div>

                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                           placeholder="Confirmer le mot de passe" required>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    <i class="bi bi-person-check-fill"></i> Créer mon compte
                </button>
            </form>

            <div class="text-center mt-4 small">
                Déjà un compte ? <a href="{{ route('login') }}" class="lien-teal">Se connecter</a>
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
        const champs = [document.getElementById('password'), document.getElementById('password_confirmation')];
        const eye = document.getElementById('eye');
        const show = champs[0].type === 'password';
        champs.forEach(c => c.type = show ? 'text' : 'password');
        eye.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    }
</script>
</body>
</html>