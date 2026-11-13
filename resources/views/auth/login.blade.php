<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SGSPIP</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, rgba(0,122,55,.78) 0%, rgba(244,153,42,.68) 100%), url('{{ asset('images/photo-abidjan-fond.jpg') }}') center/cover no-repeat fixed;
        }
        .login-card { border: none; border-radius: 1.1rem; box-shadow: 0 20px 60px rgba(0,0,0,.35); overflow:hidden; backdrop-filter: blur(2px); }
        .login-side {
            position: relative;
            color:#fff;
            background: linear-gradient(160deg, rgba(0,122,55,.82) 0%, rgba(244,153,42,.82) 100%), url('{{ asset('images/infrastructures-ivoiriennes-fond.jpg') }}') center/cover no-repeat;
            overflow: hidden;
        }
        .login-side .deco-circle { position:absolute; border-radius:50%; background:rgba(255,255,255,.12); }
        .login-side-content { position: relative; z-index: 2; }
        .brand-badge { width:92px;height:92px;border-radius:50%; background:#fff; display:flex; align-items:center; justify-content:center; padding:10px; box-shadow: 0 8px 22px rgba(0,0,0,.25); }
        .brand-badge img { width:100%; height:100%; object-fit:contain; }
        .form-control:focus { border-color:#F4992A; box-shadow: 0 0 0 .2rem rgba(244,153,42,.15); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card login-card">
                <div class="row g-0">
                    <div class="col-md-5 login-side p-4 d-flex flex-column justify-content-center align-items-center text-center">
                        <div class="deco-circle" style="width:140px;height:140px; top:-40px; right:-40px;"></div>
                        <div class="deco-circle" style="width:90px;height:90px; bottom:30px; left:-30px;"></div>
                        <div class="login-side-content">
                            <div class="brand-badge mb-3 mx-auto">
                                <img src="{{ asset('images/armoiries-ci.png') }}" alt="Armoiries de la Côte d'Ivoire">
                            </div>
                            <h5 class="fw-bold">SGSPIP</h5>
                            <p class="small mb-0">Système Intégré de Gestion et de Suivi des Projets d'Investissement Public</p>
                            <p class="small mt-3 mb-0 opacity-75">Ministère du Plan et du Développement</p>
                        </div>
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
                            <button type="submit" class="btn btn-lg w-100" style="background:linear-gradient(135deg,#F4992A,#D9811A); color:#fff; border:0; box-shadow:0 4px 14px rgba(244,153,42,.35);">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
