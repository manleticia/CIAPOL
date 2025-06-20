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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title m-0">Liste des administrateurs</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="#" class="btn btn-primary d-inline">Ajouter un
                            administrateur</a>
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
                                    <th>Statut</th>
                                    <th>Actions</th>
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
                                                alt="profile-image">
                                            <span>{{ $administrateur->nom }} {{ $administrateur->prenom }}</span>
                                        </td>
                                        <td>{{ $administrateur->email }}</td>
                                        <td>{{ $administrateur->contact ?? '-' }}</td>
                                        {{-- <td>{{ $administrateur->ville->libelle }}</td> --}}
                                        <td>{{ $administrateur->adresse }}</td>
                                        <td>{{ $administrateur->genre }}</td>
                                        {{-- <td>{!! $isOnline !!}</td> --}}
                                        <td>{!! $statusBadge !!}</td>
                                        <td>
                                            {{-- <a href="{{ route('administrateurs.show',$administrateur->id) }}" id="ShowAdmin" class="btn btn-link btn-sm text-success infoIcon" data-bs-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#info_admin" data-bs-placement="top" title="Infos"><i class="fa fa-eye"></i></a> --}}
                                            <a href="#" id="EditAdmin"
                                                class="btn btn-link btn-sm text-primary editIcon"
                                                data-bs-target="#edit_admin" title="Modifier"><i
                                                    class="fa fa-pencil"></i></a>
                                            <a href="#deleteModal{{ $administrateur->id }}" id="DeleteAdministrateur"
                                                class="btn btn-link btn-sm text-danger deleteIcon" data-bs-toggle="modal"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
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
                                                        <h4>Vous êtes sur le point de supprimer <br>un administrateur ?</h4>
                                                        <p class="text-muted fs-15 mb-4">En supprimant cet administrateur,
                                                            vous supprimez
                                                            <br> toutes les informations le concernant de notre base de
                                                            données.
                                                        </p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Fermer</button>

                                                            <form method="POST" action="#">
                                                                @csrf
                                                                @method('DELETE')
                                                                {{-- <input name="_method" type="hidden" value="DELETE"> --}}
                                                                <button class="btn btn-danger" id="delete-record">Oui,
                                                                    supprimer</button>
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
