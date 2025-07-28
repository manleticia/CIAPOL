@extends('layouts.dashboard', ['title' => $title ?? 'Liste des entreprises'])
@push('css')
    <!-- Application vendor css url -->
    <link rel="stylesheet" href="{{ asset('assets/cssbundle/dataTables.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title m-0">Liste des administrateurs</h6>
                    <div class="dropdown morphing scale-left">
                         {{-- <a href="{{ route('cheque.export.excel') }}" class="btn btn-outline-success me-2">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </a>
                        <a href="{{ route('cheque.export.pdf') }}" class="btn btn-outline-danger me-2">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </a> --}}
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        @if ($ver->id_parains == 0 || $ver->id_parains == 1)
                            <a href="{{ route('administrateur.create') }}" class="btn btn-primary d-inline">Ajouter un
                                administrateur</a>
                        @endif
                    </div>


                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="entreprisesTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>Nom et Prenoms </th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Adresse</th>
                                    <th>genre</th>
                                    <th>Profil</th>
                                    <th>Statut</th>
                                    @if ($ver->id_parains == 0 || $ver->id_parains == 1)
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($administrateurs as $index => $administrateur)
                                    @php
                                        $imgUrl = $administrateur->lien_photo
                                            ? asset($administrateur->lien_photo)
                                            : asset('assets/img/default-img.png');
                                        $statusBadge =
                                            $administrateur->status == 1
                                                ? '<span class="badge bg-success"> Compte Actif </span>'
                                                : '<span class="badge bg-danger"> Compte Inactif </span>';
                                        $isOnline =
                                            $administrateur->disponibilite == 'en ligne'
                                                ? '<span class="badge bg-success"> En ligne </span>'
                                                : '<span class="badge bg-danger"> Hors Ligne </span>';
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{ $imgUrl }}" class="avatar sm rounded me-2"
                                                alt="profile-image"> <br>
                                            <span>{{ $administrateur->nom }} {{ $administrateur->prenom }}</span>
                                        </td>
                                        <td>{{ $administrateur->contact ?? '-' }}</td>
                                        <td>{{ $administrateur->email }}</td>
                                        {{-- <td>{{ $administrateur->ville->libelle }}</td> --}}
                                        <td>{{ $administrateur->adresse }}</td>
                                        <td>{{ $administrateur->genre }}</td>
                                        <td>
                                            @if ($administrateur->profil == 'administrateur')
                                                Administrateur CIAPOL
                                            @else
                                                Administrateur BMI-WFS
                                            @endif
                                        </td>
                                        {{-- <td>{!! $isOnline !!}</td> --}}
                                        <td>{!! $statusBadge !!}</td>
                                        @if ($ver->id_parains == 0 || $ver->id_parains == 1)
                                            <td>
                                                @if ($administrateur->status == 2)
                                                    <a href="#deleteModal{{ $administrateur->id }}" id="RestaurerActualite"
                                                        class="btn btn-link btn-sm text-danger refreshIcon"
                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Restaurer"><i
                                                            class="fa fa-refresh"></i></a>
                                                @else
                                                    <a href="{{ route('administrateur.edit', $administrateur->id) }}"
                                                        id="EditAdmin" class="btn btn-link btn-sm text-primary editIcon"
                                                        data-bs-target="#edit_admin" title="Modifier"><i
                                                            class="fa fa-pencil"></i></a>
                                                    <a href="#deleteModal{{ $administrateur->id }}"
                                                        id="DeleteAdministrateur"
                                                        class="btn btn-link btn-sm text-danger deleteIcon"
                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Supprimer"><i
                                                            class="fa fa-trash"></i></a>
                                                    <a href="#passeModal{{ $administrateur->id }}"
                                                        id="DeleteAdministrateur"
                                                        class="btn btn-link btn-sm text-danger deleteIcon"
                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Réinitialiser le mot de passe.">

                                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                            width="20" height="20"
                                                            viewBox="0 0 512.000000 512.000000"
                                                            preserveAspectRatio="xMidYMid meet">
                                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                                fill="#000000" stroke="none">
                                                                <path
                                                                    d="M2375 5016 c-169 -45 -300 -118 -415 -235 -162 -163 -260 -395 -260
                                                                        -612 0 -111 24 -123 224 -117 146 4 154 10 167 123 4 43 14 94 20 114 37 113
                                                                        125 231 217 289 268 171 634 36 734 -271 17 -51 22 -97 26 -259 l4 -197 -733
                                                                        -3 c-682 -3 -737 -4 -774 -21 -51 -23 -91 -61 -118 -112 -22 -40 -22 -45 -25
                                                                        -724 -3 -754 -3 -755 59 -825 16 -19 51 -45 77 -58 l47 -23 910 -3 c557 -2
                                                                        934 1 973 7 82 13 146 58 182 126 l25 49 0 696 c0 775 3 743 -70 815 -39 39
                                                                        -68 54 -136 69 l-26 6 -6 202 c-7 225 -26 330 -85 460 -106 234 -316 418 -567
                                                                        498 -55 17 -102 23 -215 26 -129 4 -155 2 -235 -20z m300 -1735 c93 -42 144
                                                                        -142 124 -245 -10 -52 -15 -61 -65 -116 l-32 -35 -4 -178 -3 -179 -33 -29
                                                                        c-46 -41 -111 -41 -153 0 l-29 29 0 167 c0 170 -5 197 -41 223 -26 18 -66 91
                                                                        -73 134 -15 82 41 185 123 228 47 25 133 26 186 1z" />
                                                                <path d="M453 1418 c-32 -16 -43 -59 -43 -170 l0 -100 -67 38 c-146 82 -139
                                                                        79 -169 69 -36 -13 -59 -53 -50 -88 5 -21 30 -41 112 -88 l105 -62 -100 -58
                                                                        c-55 -33 -105 -68 -111 -80 -18 -34 -2 -79 33 -94 37 -15 49 -12 156 50 43 25
                                                                        81 45 84 45 3 0 7 -51 9 -114 2 -95 6 -117 22 -135 28 -31 79 -28 105 5 18 23
                                                                        21 41 21 140 l0 113 96 -56 c106 -62 147 -69 176 -32 43 52 19 89 -101 158
                                                                        -50 29 -91 55 -91 59 0 4 43 31 95 61 96 54 115 72 115 111 0 27 -43 70 -71
                                                                        70 -12 0 -65 -25 -116 -55 -52 -30 -96 -55 -98 -55 -2 0 -5 54 -7 120 -3 128
                                                                        -9 144 -58 154 -14 3 -35 0 -47 -6z" />
                                                                <path d="M1826 1409 c-26 -20 -26 -23 -26 -141 0 -94 -3 -119 -13 -115 -7 3
                                                                        -53 28 -102 56 -49 28 -99 51 -111 51 -36 0 -67 -32 -66 -69 1 -44 11 -54 120
                                                                        -118 l94 -56 -28 -17 c-16 -10 -62 -36 -101 -59 -54 -31 -75 -49 -80 -69 -9
                                                                        -34 -5 -52 14 -74 28 -31 72 -21 173 37 l95 55 5 -126 c5 -138 13 -154 72
                                                                        -154 51 0 62 27 68 160 l5 120 94 -55 c101 -59 146 -69 174 -37 23 25 22 77
                                                                        -3 99 -10 10 -57 41 -104 68 -47 27 -83 52 -80 56 2 4 45 31 94 59 50 28 95
                                                                        60 100 70 26 49 -5 110 -56 110 -14 0 -68 -25 -119 -55 -52 -30 -96 -55 -99
                                                                        -55 -3 0 -6 54 -6 119 0 117 -1 120 -26 140 -15 12 -34 21 -44 21 -10 0 -29
                                                                        -9 -44 -21z" />
                                                                <path
                                                                    d="M3206 1409 c-25 -20 -26 -23 -26 -140 0 -65 -3 -119 -6 -119 -3 0
                                                                        -47 25 -99 55 -51 30 -105 55 -119 55 -51 0 -82 -61 -56 -110 5 -10 50 -42
                                                                        100 -70 49 -28 92 -55 94 -59 3 -4 -33 -29 -80 -56 -47 -27 -94 -58 -104 -68
                                                                        -26 -23 -26 -78 -2 -100 32 -29 74 -20 173 38 l94 55 5 -120 c6 -133 17 -160
                                                                        68 -160 59 0 67 16 72 154 l5 126 95 -55 c101 -58 145 -68 173 -37 19 22 23
                                                                        40 14 74 -6 21 -30 41 -108 86 l-102 60 95 56 c110 64 119 73 120 117 1 36
                                                                        -30 69 -66 69 -11 0 -65 -25 -119 -55 -53 -30 -100 -55 -102 -55 -3 0 -5 54
                                                                        -5 119 0 117 -1 120 -26 140 -15 12 -34 21 -44 21 -10 0 -29 -9 -44 -21z" />
                                                                <path d="M4589 1411 c-22 -18 -24 -27 -27 -140 -2 -67 -5 -121 -7 -121 -1 0
                                                                        -45 25 -96 55 -52 30 -104 55 -117 55 -31 0 -72 -43 -72 -75 0 -34 21 -53 123
                                                                        -111 48 -27 87 -52 87 -56 0 -3 -40 -30 -90 -58 -49 -28 -97 -61 -105 -73 -21
                                                                        -30 -19 -63 5 -87 33 -33 76 -25 175 34 l90 54 5 -118 c6 -134 18 -160 75
                                                                        -160 58 0 70 26 73 160 l4 118 92 -54 c122 -71 174 -71 192 2 10 38 -16 66
                                                                        -115 123 -50 29 -91 55 -91 59 0 4 38 29 85 56 89 50 125 85 125 118 0 26 -44
                                                                        68 -72 68 -13 0 -66 -25 -118 -54 l-95 -55 -6 112 c-6 126 -10 140 -45 156
                                                                        -35 15 -48 14 -75 -8z" />
                                                                <path d="M40 309 c-36 -15 -40 -26 -40 -116 0 -61 4 -86 16 -97 14 -14 70 -16
                                                                        473 -16 381 0 461 2 470 14 8 9 11 47 9 107 -3 88 -4 94 -28 106 -31 16 -861
                                                                        18 -900 2z" />
                                                                <path d="M1423 310 c-12 -5 -26 -18 -32 -29 -17 -31 -14 -153 5 -179 l15 -22
                                                                        458 0 c414 0 460 2 472 17 9 11 14 43 14 99 0 129 42 119 -473 121 -240 1
                                                                        -447 -2 -459 -7z" />
                                                                <path d="M2801 308 c-15 -8 -28 -27 -34 -48 -11 -43 -3 -146 13 -165 11 -13
                                                                        81 -15 471 -15 l458 0 15 22 c24 34 22 159 -3 189 l-19 24 -439 3 c-335 1
                                                                        -444 -1 -462 -10z" />
                                                                <path d="M4180 307 c-24 -12 -25 -18 -28 -106 -2 -60 1 -98 9 -107 9 -12 89
                                                                        -14 470 -14 403 0 459 2 473 16 12 11 16 36 16 97 0 92 -4 101 -43 116 -43 17
                                                                        -864 15 -897 -2z" />
                                                            </g>
                                                        </svg>

                                                    </a>
                                                @endif
                                                {{-- <a href="{{ route('administrateurs.show',$administrateur->id) }}" id="ShowAdmin" class="btn btn-link btn-sm text-success infoIcon" data-bs-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#info_admin" data-bs-placement="top" title="Infos"><i class="fa fa-eye"></i></a> --}}

                                            </td>
                                        @endif
                                    </tr>

                                    <!-- Modal delete-->
                                    <div class="modal fade flip" id="deleteModal{{ $administrateur->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                        colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px">
                                                    </lord-icon>
                                                    <div class="mt-4 text-center">

                                                        @if ($administrateur->status == 2)
                                                            <h4>Vous êtes sur le point de restaurer <br>un administrateur ?
                                                            </h4>
                                                            <p class="text-muted fs-15 mb-4">En restaurant cet
                                                                administrateur, vous
                                                                ramener
                                                                <br> toutes les informations la concernant de notre base de
                                                                données.
                                                            </p>
                                                        @else
                                                            <h4>Vous êtes sur le point de supprimer <br>un administrateur ?
                                                            </h4>
                                                            <p class="text-muted fs-15 mb-4">En supprimant cet
                                                                administrateur,
                                                                vous supprimez
                                                                <br> toutes les informations le concernant de notre base de
                                                                données.
                                                            </p>
                                                        @endif
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Fermer</button>
                                                            @if ($administrateur->status == 2)
                                                                <form method="POST"
                                                                    action="{{ route('activAdmin', $administrateur->id) }}">
                                                                    @method('POST')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger"
                                                                        id="delete-record">Oui,
                                                                        restaurer</button>
                                                                </form>
                                                            @else
                                                                <form method="POST"
                                                                    action="{{ route('desactAdmin', $administrateur->id) }}">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button class="btn btn-danger" id="delete-record">Oui,
                                                                        supprimer</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade flip" id="passeModal{{ $administrateur->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                        colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px">
                                                    </lord-icon>
                                                    <div class="mt-4 text-center">


                                                        <h4>Vous êtes sur le point de réinitialiser<br>le mot de passe de
                                                            cet administrateur :<br> {{ $administrateur->nom ?? "xxxxx" }} {{ $administrateur->prenom ?? "xxxxx" }}</h4>
                                                        <p class="text-muted fs-15 mb-4">
                                                           La réinitialisation du mot de passe entraînera l'envoi  <br> d'un e-mail à l'adresse de l'administrateur. Cette action est irréversible..<br>
                                                            Voulez-vous continuer ?
                                                        </p>

                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-danger"
                                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle "></i>
                                                                Fermer</button>

                                                                <form method="POST"
                                                                    action="{{ route('reinitMotPass', $administrateur->id) }}">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button class="btn btn-primary" id="delete-record">Oui,
                                                                        continuer</button>
                                                                </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
