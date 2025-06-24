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

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Paramètres</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary d-inline">Retour</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-4">
            <div class="list-group list-group-custom sticky-top me-xl-4" style="top: 100px;">
                <a class="list-group-item list-group-item-action" href="#list-item-1">Mon profil</a>
                <a class="list-group-item list-group-item-action" href="#list-item-2">Changer Mot de passe</a>
            </div>
        </div>
        <div class="col-xxl-8 col-lg-8 col-md-8">
            <div id="list-item-1" class="card fieldset border border-muted mt-5">
                <!-- form: profile details -->
                <span class="fieldset-tile text-muted bg-body">Détail du profil:</span>
                <form action="{{ route('administrateur.update',$administrateur->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <label class="col-form-label">Photo</label>
                                <div class="col-md-6 col-sm-6">
                                   
                                    @if (Auth::check() && auth()->user()->administrateur->lien_photo)
                                        <div class="image-input avatar xxl rounded-4"
                                            style="background-image: url({{ auth()->user()->administrateur->lien_photo }})">
                                            <div class="avatar-wrapper rounded-4"
                                                style="background-image: url(url({{ auth()->user()->administrateur->lien_photo }})">
                                            </div>
                                            <div class="file-input">
                                                <input type="file"
                                                    class="form-control @error('lien_photo') is-invalid @enderror"
                                                    name="lien_photo" id="lien_photo">
                                                <label for="lien_photo" class="fa fa-pencil shadow text-muted"></label>
                                                @error('lien_photo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @else
                                        <div class="image-input avatar xxl rounded-4"
                                            style="background-image: url({{ asset($administrateur->lien_photo ??'../assets/icons/user2.png') }})">
                                            <div class="avatar-wrapper rounded-4"
                                                style="background-image: url({{ asset($administrateur->lien_photo ??'../assets/icons/user2.png') }})">
                                            </div>
                                            <div class="file-input">
                                                <input type="file" class="form-control" name="lien_photo"
                                                    id="lien_photo">
                                                <label for="lien_photo" class="fa fa-pencil shadow text-muted"></label>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" id="nom" name="nom"
                                            class="form-control @error('nom') is-invalid @enderror"
                                            value="{{ old('nom', $administrateur->nom) }}" placeholder="Nom"
                                            autocomplete="nom" autofocus required>
                                        <label>Entrez le nom<span class="text-danger fw-bold">*</span></label>
                                        @error('nom')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-3">
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
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email"
                                            value="{{ old('email', $administrateur->email) }}" placeholder="Email"
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
                                            <input type="text"
                                                class="form-control @error('contact') is-invalid @enderror" id="contact"
                                                name="contact" value="{{ old('contact', $administrateur->contact) }}"
                                                minlength="10" maxlenghth="10" placeholder="Ex: 0777007700"
                                                autocomplete="contact" autofocus required>
                                            @error('contact')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <label>Entrez un contact<span class="text-danger fw-bold">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('genre') is-invalid @enderror"
                                            id="genre" name="genre" autocomplete="genre" autofocus required>
                                            <option value="">Sélectionnez le genre</option>
                                            @foreach (['Homme', 'Femme'] as $genre)
                                                <option value="{{ $genre }} "
                                                    {{ old('genre', $administrateur->genre) == $genre ? 'selected' : '' }}>
                                                    {{ $genre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('genre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="floatingSelect">Genre<span
                                                class="text-danger fw-bold">*</span></label>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 mb-3">
                                    <div class="form-floating">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('adresse') is-invalid @enderror" id="adresse"
                                                name="adresse" value="{{ old('adresse', $administrateur->adresse) }}"
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
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-light me-2">Annuler</a>
                            <button class="btn btn-lg btn-primary" type="submit">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="list-item-2" class="card fieldset border border-muted mt-5">
                <!-- form: Change Password -->
                <span class="fieldset-tile text-muted bg-body">Changer le mot de passe</span>
                <form action="{{ route('posMotPass',$administrateur->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                            value="{{ $administrateur->nom }} {{ $administrateur->prenom }}" disabled
                                            placeholder="Nom et prénoms">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="email"  id="email" class="form-control"
                                            value="{{ old('email', $administrateur->user->email) }}" disabled
                                            placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="contact" value="{{ old('email', $administrateur->contact) }}"
                                            class="form-control" disabled placeholder="Contact">
                                    </div>
                                </div>
                                <div class="col-12">
                                     <input type="email"   name="email" class="form-control"
                                            value="{{ old('email', $administrateur->user->email) }}" style="display: none"
                                            placeholder="Email">
                                    <h6 class="border-top pt-2 mt-2 mb-3">Changer le mot de passe</h6>
                                    <div class="row mb-3">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-1">
                                                <input type="password" name="password" id="password"
                                                    class="form-control form-control-lg  @error('password') is-invalid @enderror"
                                                    min="6" placeholder="Nouveau mot de passe">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div>
                                                <input type="password" name="password_confirmation" id="password-confirm"
                                                    class="form-control form-control-lg  @error('password_confirmation') is-invalid @enderror"
                                                    min="6" placeholder="Confirmer le nouveau mot de passe"
                                                    autocomplete="password_confirmation">
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-light me-2">Annuler</a>
                            <button class="btn btn-lg btn-primary" type="submit">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
@endsection

@push('js')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets/js/bundle/dataTables.bundle.js') }}"></script>
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
