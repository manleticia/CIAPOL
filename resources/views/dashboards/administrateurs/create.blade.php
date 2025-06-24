@extends('layouts.dashboard', ['title' => $title ?? 'Liste des entreprises'])
@push('css')
    <!-- Application vendor css url -->
    <link rel="stylesheet" href="{{ asset('assets/cssbundle/dataTables.min.css') }}">
@endpush
@section('content')
    <div class="row g-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <h5>Erreurs lors de l'importation :</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="dropdown morphing scale-left">

            <a href="{{ route('administrateur.index') }}" class="btn btn-primary d-inline">Retour</a>
        </div>

        <div class="card-body" id="add_administrator">
            <h6 class="fw-bold">Informations de l'administrateur</h6>
            <form action="{{ route('administrateur.store') }}" method="POST" id="add_admin_form"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-floating">
                            <input type="file" name="lien_photo"
                                class="form-control @error('lien_photo') is-invalid @enderror">
                            <label>Photo <span class="text-danger">(laisser vide si inchangée)</span></label>
                            @error('lien_photo')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-floating">
                            <input type="text" id="nom" name="nom"
                                class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}"
                                placeholder="Nom" autocomplete="nom" autofocus required>
                            <label>Entrez le nom<span class="text-danger fw-bold">*</span></label>
                            @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="text" id="prenom" name="prenom"
                                class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}"
                                placeholder="Prénom(s)" autocomplete="prenom" autofocus required>
                            <label>Entrez le Prénom(s)<span class="text-danger fw-bold">*</span></label>
                            @error('prenom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="form-floating">
                            <select class="form-select form-control @error('genre') is-invalid @enderror" id="genre"
                                name="genre" autocomplete="genre" autofocus require>
                                <option value="">Sélectionnez le genre</option>
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                            </select>
                            @error('genre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="floatingSelect">Genre<span class="text-danger fw-bold">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="form-floating">
                            <select class="form-select form-control @error('profil') is-invalid @enderror" id="profil"
                                name="profil" autocomplete="profil" autofocus require>
                                <option value="">Sélectionnez le profil</option>
                                <option value="administrateur">Administrateur Ciapol</option>
                                <option value="superAdministrateur">Administrateur BMI-WFS</option>
                            </select>
                            @error('profil')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="floatingSelect">Profil<span class="text-danger fw-bold">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email"
                                autofocus required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label>Entrez une adresse email<span class="text-danger fw-bold">*</span></label>
                        </div>
                    </div>


                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('adresse') is-invalid @enderror"
                                    id="adresse" name="adresse" placeholder="adresse" autocomplete="adresse"
                                    autofocus>
                                @error('adresse')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label>Entrez une adresse</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('contact') is-invalid @enderror"
                                    id="contact" name="contact" value="{{ old('contact') }}" minlength="10"
                                    maxlenghth="10" placeholder="Ex: 0777007700" autocomplete="contact" autofocus
                                    required>
                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label>Entrez un contact<span class="text-danger fw-bold">*</span></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-3">
                    <p><span class="text-danger fw-bold">*</span>Champs obligatoires.</p>
                </div>
                <div class="row g-3 ">
                    <div class="mx-auto d-flex justify-content-center">

                        <button type="reset" class="btn btn-secondary w-25 mx-2">Annuler</button>
                        <button type="submit" id="add_admin_btn" class="btn btn-primary w-25 mx-2">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#entreprisesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json'
                },
                responsive: true,
                dom: '<"top"lf>rt<"bottom"ip>',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                columnDefs: [{
                        orderable: false,
                        targets: [7]
                    } // Désactiver le tri sur la colonne Actions
                ]
            });

            // Initialiser les tooltips Bootstrap
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
