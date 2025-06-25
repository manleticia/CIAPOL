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
            <form action="{{ route('udpaAdminUser', $administrateur->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-floating">
                            {{-- <input type="file" name="lien_photo"
                                class="form-control @error('lien_photo') is-invalid @enderror">
                            <label>Photo <span class="text-danger">(laisser vide si inchangée)</span></label>
                            @error('lien_photo')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror --}}
                            <div class="image-input avatar xxl rounded-4"
                                style="background-image: url({{ $administrateur->lien_photo ? asset($administrateur->lien_photo) : asset('../assets/icons/user2.png') }})">

                                <div class="avatar-wrapper rounded-4"
                                    style="background-image: url({{ $administrateur->lien_photo ? asset($administrateur->lien_photo) : asset('../assets/icons/user2.png') }})">
                                </div>

                                <div class="file-input">
                                    <input type="file" class="form-control @error('lien_photo') is-invalid @enderror"
                                        name="lien_photo" id="lien_photo" accept="image/*">

                                    <label for="lien_photo" class="fa fa-pencil shadow text-muted"></label>

                                    @error('lien_photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-floating">
                            <input type="text" id="nom" name="nom"
                                class="form-control @error('nom') is-invalid @enderror"
                                value="{{ old('nom', $administrateur->nom) }}" placeholder="Nom" autocomplete="nom"
                                autofocus required>
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
                                class="form-control @error('prenom') is-invalid @enderror"
                                value="{{ old('prenom', $administrateur->prenom) }}" placeholder="Prénom(s)"
                                autocomplete="prenom" autofocus required>
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
                                name="genre" autocomplete="genre" required>
                                <option value="">Sélectionnez le genre</option>
                                <option value="Homme"
                                    {{ old('genre', $administrateur->genre ?? '') == 'Homme' ? 'selected' : '' }}>Homme
                                </option>
                                <option value="Femme"
                                    {{ old('genre', $administrateur->genre ?? '') == 'Femme' ? 'selected' : '' }}>Femme
                                </option>
                            </select>

                            @error('genre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="genre">Genre <span class="text-danger fw-bold">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="form-floating">
                         <select class="form-select form-control @error('profil') is-invalid @enderror"
        id="profil" name="profil" autocomplete="profil" required>

    <option value="">Sélectionnez le profil</option>

    <option value="administrateur"
        {{ old('profil', $administrateur->profil) == 'administrateur' ? 'selected' : '' }}>
        Administrateur CIAPOL
    </option>

    <option value="superAdministrateur"
        {{ old('profil', $administrateur->profil) == 'superAdministrateur' ? 'selected' : '' }}>
        Administrateur BMI-WFS
    </option>

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
                                name="email" value="{{ old('email', $administrateur->email) }}" placeholder="Email"
                                autocomplete="email" autofocus required>
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
                                    id="adresse" name="adresse" value="{{ old('adresse', $administrateur->adresse) }}"
                                    placeholder="adresse" autocomplete="adresse" autofocus>
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
                                    id="contact" name="contact" value="{{ old('contact', $administrateur->contact) }}"
                                    minlength="10" maxlenghth="10" placeholder="Ex: 0777007700" autocomplete="contact"
                                    autofocus required>
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
                        <a  href="{{ route('administrateur.index') }}" class="btn btn-secondary w-25 mx-2">Annuler</a>
                        <button type="submit" class="btn btn-primary w-25 mx-2">Enregistrer</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionner l'input file et les éléments d'affichage
            const fileInput = document.getElementById('lien_photo');
            const avatarWrapper = document.querySelector('.avatar-wrapper');
            const imageInput = document.querySelector('.image-input');

            // Écouter le changement sur l'input file
            fileInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        // Mettre à jour l'image de fond
                        avatarWrapper.style.backgroundImage = `url(${event.target.result})`;
                        imageInput.style.backgroundImage = `url(${event.target.result})`;
                    };

                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            // Déclencher le clic sur l'input file quand on clique sur l'image
            imageInput.addEventListener('click', function(e) {
                // Empêcher le déclenchement multiple si on clique sur l'input
                if (e.target !== fileInput) {
                    fileInput.click();
                }
            });
        });
    </script>
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
