<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Plateforme de CIAPOL">
    <meta name="keyword" content="Plateforme de CIAPOL">
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon"> <!-- Favicon-->
    <title>{{ $title ?? 'Connexion' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/luno-style.css') }}">

    <script src="{{ asset('assets/js/plugins.js') }}"></script>
</head>

<body id="layout-1" data-luno="theme-blue">

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}

        </div>
    @endif




    <!-- start: body area -->
    <div class="wrapper">
        <!-- Sign In version 1 -->
        <!-- start: page body -->
        <div class="page-body auth px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
            <div class="container-fluid">
                <div class="row g-0">
                    <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center">
                        <div style="max-width: 25rem;">
                            <div class="mb-4">
                                <a href="{{ route('acceuil') }}">
                                    <img class="img-fluid" src="{{ asset('photos/logo.png') }}" alt="Logo">
                                </a>
                            </div>
                            <div class="mb-5">
                                <h2 class="color-900">Bienvenue sur la page de connexion de CIAPOL:</h2>
                            </div>
                            <!-- List Checked -->
                            <ul class="list-unstyled mb-5">
                                <li>
                                    <span class="d-block mb-1 fs-4 fw-light">Inscrivez vous si vous etes nouveaux sur la
                                        plateforme</span>
                                    <span class="color-600">En dessous du bouton "Se connecter"</span>
                                </li>
                                <li class="mb-4">
                                    <span class="d-block mb-1 fs-4 fw-light">Connectez Vous </span>
                                    <span class="color-600">Pour avoir les informations liees a votre compte</span>
                                </li>

                            </ul>


                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="card shadow-sm w-100 p-4 p-md-5" style="max-width: 32rem;">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <h5>Erreurs lors de l'importation :</h5>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <!-- Form -->
                            <form class="row g-3" method="POST" action="{{ route('connexion.Utilisateur') }}">
                                @csrf
                                <div class="col-12 text-center mb-5">
                                    <h1>Connexion</h1>
                                    <span class="text-muted">Accès gratuit à notre tableau de bord.</span>
                                </div>

                                <div class="col-12">

                                    <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            placeholder="name@example.com" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="form-label">Mot de passe</label>
                                        <input id="password" name="password" class="form-control form-control-lg"
                                            type="password" placeholder="Entrez le mot de passe" required>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-lg btn-block btn-dark lift text-uppercase">Se
                                        connecter</button>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <span class="text-muted">Vous n'avez pas encore de compte ? <a
                                            href="{{ route('inscriptionVitrine') }}">Inscrivez-vous ici</a></span>
                                </div>
                            </form>
                            <!-- End Form -->

                        </div>
                    </div>
                </div> <!-- End Row -->
            </div>
        </div>
        <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
        <script>
            $(function() {
                $('#password').password()
            })
        </script>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <!-- Plugin Js -->
    <!-- Vendor Script -->
</body>

</html>
