<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SGSPIP</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #009A44 0%, #FF8200 100%);
        }
        .login-card { border: none; border-radius: 1rem; box-shadow: 0 10px 40px rgba(0,0,0,.25); overflow:hidden; }
        .login-side { background: rgba(0,0,0,.15); color:#fff; }
        .brand-badge { width:88px;height:88px;border-radius:50%; background:#fff; display:flex; align-items:center; justify-content:center; padding:8px; box-shadow: 0 4px 14px rgba(0,0,0,.2); }
        .brand-badge img { width:100%; height:100%; object-fit:contain; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card login-card">
                <div class="row g-0">
                    <div class="col-md-5 login-side p-4 d-flex flex-column justify-content-center align-items-center text-center">
                        <div class="brand-badge mb-3">
                            <img src="{{ asset('images/armoiries-ci.png') }}" alt="Armoiries de la Côte d'Ivoire">
                        </div>
                        <h5 class="fw-bold">SGSPIP</h5>
                        <p class="small mb-0">Système Intégré de Gestion et de Suivi des Projets d'Investissement Public</p>
                        <p class="small mt-3 mb-0 opacity-75">Ministère de l'Économie, du Plan et du Développement</p>
                    </div>
                    <div class="col-md-7 p-4 p-md-5 bg-white">
                        <h4 class="fw-bold mb-1">Connexion</h4>
                        <p class="text-muted small mb-4">Veuillez saisir vos identifiants pour accéder au système.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Adresse e-mail</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Se souvenir de moi</label>
                            </div>
                            <button type="submit" class="btn btn-lg text-white w-100" style="background-color:#FF8200;">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
