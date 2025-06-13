<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Plateforme de CIAPOL.">
    <meta name="keyword" content="Plateforme de CIAPOL">
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon"> <!-- Favicon-->
    <title>{{ $title ?? 'Inscription' }}</title>
    <!-- Application vendor css url -->
    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('assets/css/luno-style.css') }}">
    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
</head>

<body id="layout-1" data-luno="theme-blue">
    <!-- start: body area -->
    <div class="wrapper">
        <!-- Sign In version 1 -->
        <!-- start: page body -->
        <div class="page-body auth px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
            <div class="container-fluid">
                <div class="row g-3">
                    <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center">
                        <div style="max-width: 25rem;">
                            <div class="mb-4">
                                <a href="{{ route('acceuil') }}">
                                    <img class="img-fluid" src="{{ asset('photos/logo.png') }}" alt="Logo">
                                </a>
                            </div>
                            <div class="mb-5">
                                <h2 class="color-900">Bienvenue sur la page d'inscription de CIAPOL:</h2>
                            </div>
                            <!-- List Checked -->
                            <ul class="list-unstyled mb-5">
                                <li class="mb-4">

                                </li>
                                <li>

                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="card shadow-sm w-100 p-4 p-md-5" style="max-width: 32rem;">
                            <!-- Form -->
                            <form class="row" method="POST" action="{{ route('inscriptionVitrine.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-sm-4 col-form-label">Raison Sociale<span
                                                style="color:red">*</span></label>
                                        <div class="col-md-9 col-sm-8">
                                            <input type="text" name="libelle" value="{{ old('libelle') }}"
                                                placeholder="Libellé de votre installation"
                                                class="form-control form-control-lg @error('libelle') is-invalid @enderror">
                                            @error('libelle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-sm-4 col-form-label">Ancienne Raison Sociale </label>
                                        <div class="col-md-9 col-sm-8">
                                            <input type="text" name="ancien_libelle"
                                                value="{{ old('ancien_libelle') }}"
                                                placeholder="Seulement si vous avez un autre avant"
                                                class="form-control form-control-lg @error('ancien_libelle') is-invalid @enderror">
                                            @error('ancien_libelle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-sm-4 col-form-label">Email <span
                                                style="color:red">*</span></label>
                                        <div class="col-md-9 col-sm-8">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                placeholder="exemple@domaine.com" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-sm-4 col-form-label">Téléphone <span
                                                style="color:red">*</span></label>
                                        <div class="col-md-9 col-sm-8">
                                            <input type="tel" name="telephone" value="{{ old('telephone') }}"
                                                class="form-control form-control-lg @error('telephone') is-invalid @enderror"
                                                placeholder="0102030405" required
                                                onKeyPress="if(this.value.length==10) return false;">
                                            @error('telephone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-sm-4 col-form-label">Nombre d'installation <span
                                                style="color:red">*</span></label>
                                        <div class="col-md-9 col-sm-8">
                                            <input type="number" name="nombre_installation"
                                                value="{{ old('nombre_installation') }}"
                                                class="form-control form-control-lg @error('nombre_installation') is-invalid @enderror"
                                                min="0" placeholder="Entrez votre nombre d'installation">
                                            @error('nombre_installation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit"
                                            class="btn btn-lg btn-block btn-dark lift text-uppercase">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                    </div>
                </div> <!-- End Row -->
            </div>
        </div>
    </div>

    <!-- Jquery Page Js -->
    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <!-- Plugin Js -->
    <!-- Vendor Script -->
</body>

</html>
