@extends('layouts.dashboard', ['title' => $title ?? 'Liste des transactions'])
@push('css')
    <!-- Application vendor css url -->
    <link rel="stylesheet" href="{{ asset('assets/cssbundle/dataTables.min.css') }}">
    <!-- Font Awesome pour les icônes -->
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
                    <h6 class="card-title m-0">Liste des transactions</h6>

                    <div>
                        <a href="{{ route('cheque.export.excel') }}" class="btn btn-outline-success me-2">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </a>
                        <a href="{{ route('cheque.export.pdf') }}" class="btn btn-outline-danger me-2">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </a>

                        <a href="{{ route('cheque.create') }}" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Nouveau
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="entreprisesTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>Raison Social </th>
                                    <th>Libelle de taxe</th>
                                    <th>Nature</th>
                                    <th>Numero du Cheque</th>
                                    <th>Montant</th>
                                    <th>Banque</th>
                                    <th>Titulaire</th>
                                    <th>Date emission</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cheques as $ind => $cheque)
                                    <tr>
                                        <td>{{ $ind + 1 }}</td>
                                        <td>{{ $cheque->entreprise->raison_sociale ?? 'xxxxxxxxx' }}</td>
                                        <td>{{ $cheque->taxeEntreprise->periode ?? 'TOUT' }}</td>
                                        <td>{{ $cheque->NaturePaiement ?? 'xxxxxxx' }}</td>
                                        <td>{{ $cheque->numero_cheque ?? 'xxxxxxxxx' }}
                                        </td>
                                        <td>{{ $cheque->montant ?? 'xxxxxxxxx' }} F CFA</td>
                                        <td>
                                            @if (!empty($cheque->autre_banque))
                                                {{ $cheque->autre_banque ?? 'xxxxxxxxx' }}
                                            @else
                                                {{ $cheque->banque ?? ($cheque->autre_banque ?? 'xxxxxxxxx') }}
                                            @endif
                                        </td>
                                        <td>{{ $cheque->titulaire ?? 'xxxxxxxxx' }}</td>
                                        <td>{{ $cheque->date_emission ?? 'xxxxxxxxx' }}</td>
                                        <td>
                                            @if ($cheque->status == 1)
                                                <span class="badge bg-success">
                                                    {{-- {{ $cheque->status == 1 ? 'Active' : 'Inactive' }} --}}
                                                    Valide
                                                </span>
                                            @elseif($cheque->status == 2)
                                                <span class="badge bg-primary">
                                                    {{-- {{ $cheque->status == 1 ? 'Active' : 'Inactive' }} --}}
                                                    Attente
                                                </span>
                                            @elseif($cheque->status == 4)
                                                <span class="badge bg-danger">
                                                    {{-- {{ $cheque->status == 1 ? 'Active' : 'Inactive' }} --}}
                                                    Desactivé
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    {{-- {{ $cheque->status == 1 ? 'Active' : 'Inactive' }} --}}
                                                    Refuse
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($cheque->status != DESACTIVE())
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('detail.cheques', $cheque->id) }}"
                                                        class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                        title="Voir">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                </div>
                                            @endif
                                            <div class="btn-group" role="group">
                                                @if ($cheque->status == 2)
                                                    <a href="{{ route('cheque.edit', $cheque->id) }}"
                                                        class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                        title="Voir">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            @if ($cheque->status == 2)
                                                <div class="btn-group" role="group">
                                                    <a href="#deleteModal{{ $cheque->id }}"
                                                        class="btn btn-link btn-sm text-danger deleteIcon  btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="desactiver">
                                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                            width="20" height="20"
                                                            viewBox="0 0 512.000000 512.000000"
                                                            preserveAspectRatio="xMidYMid meet">
                                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                                fill="#db3545" stroke="none">
                                                                <path
                                                                    d="M2357 5110 c-146 -14 -295 -40 -432 -75 -478 -124 -940 -403 -1262
                                                                                                                            -764 -717 -803 -863 -1906 -378 -2860 122 -241 279 -455 475 -651 440 -440
                                                                                                                            998 -698 1627 -751 471 -40 968 68 1394 302 223 123 393 252 585 444 404 403
                                                                                                                            654 912 736 1495 17 125 17 515 0 640 -66 470 -241 885 -531 1260 -84 109
                                                                                                                            -312 337 -421 421 -367 284 -772 458 -1225 525 -120 18 -446 26 -568 14z m473
                                                                                                                            -914 c527 -87 973 -414 1211 -887 239 -476 235 -1028 -10 -1498 l-23 -44
                                                                                                                            -1119 1119 c-615 615 -1119 1122 -1119 1125 0 11 191 95 287 127 81 28 243 63
                                                                                                                            343 76 64 8 344 -4 430 -18z m-586 -1955 l1129 -1129 -44 -23 c-189 -99 -373
                                                                                                                            -154 -594 -179 -663 -74 -1334 296 -1649 910 -237 462 -248 980 -28 1452 25
                                                                                                                            54 48 98 51 98 3 0 514 -508 1135 -1129z" />
                                                            </g>
                                                        </svg>

                                                    </a>
                                                </div>
                                            @endif
                                            @if ($cheque->status == DESACTIVE())
                                                <div class="btn-group" role="group">
                                                    <a href="#deleteModal{{ $cheque->id }}" id="RestaurerActualite"
                                                        class="btn btn-link btn-sm text-danger refreshIcon"
                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Restaurer"><i
                                                            class="fa fa-refresh"></i></a>
                                                </div>


                                                <div class="btn-group" role="group">
                                                    <a href="#SupprimeModal{{ $cheque->id }}"
                                                        class="btn btn-link btn-sm text-danger deleteIcon  btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Supprimer"><i
                                                            class="fa fa-trash"></i></a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade flip" id="deleteModal{{ $cheque->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                        colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px">
                                                    </lord-icon>
                                                    <div class="mt-4 text-center">
                                                        @if ($cheque->status == 2)
                                                            <h4>Vous êtes sur le point de desactiver <br>un <span
                                                                    class="text-lowercase">{{ $cheque->NaturePaiement ?? 'Cheque' }}</span>
                                                                ?</h4>
                                                            <p class="text-muted fs-15 mb-4">En desactivant @if ($cheque->NaturePaiement == 'ESPECE')
                                                                    cet
                                                                @else
                                                                    ce
                                                                @endif <span
                                                                    class="text-lowercase">{{ $cheque->NaturePaiement ?? 'Cheque' }}</span>,
                                                                vous
                                                                desactivez
                                                                <br> toutes les informations le concernant de notre base de
                                                                données.
                                                            </p>
                                                        @elseif ($cheque->status == DESACTIVE())
                                                            <h4>Vous êtes sur le point de restaurer <br>un <span
                                                                    class="text-lowercase">{{ $cheque->NaturePaiement ?? 'Cheque' }}
                                                                    ?</h4>
                                                            <p class="text-muted fs-15 mb-4">En restaurant @if ($cheque->NaturePaiement == 'ESPECE')
                                                                    cet
                                                                @else
                                                                    ce
                                                                @endif <span
                                                                    class="text-lowercase">{{ $cheque->NaturePaiement ?? 'Cheque' }}</span>,
                                                                vous
                                                                le
                                                                remettez dans la liste des <span
                                                                    class="text-lowercase">{{ $cheque->NaturePaiement ?? 'Cheque' }}</span>s
                                                                en attente.
                                                            </p>
                                                        @else
                                                            <h4>Vous êtes sur le point de supprimer <br>un chèque ?</h4>
                                                            <p class="text-muted fs-15 mb-4">En supprimant ce chèque, vous
                                                                supprimez
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
                                                            @if ($cheque->status == 2)
                                                                <form method="POST"
                                                                    action="{{ route('cheque.desAc', $cheque->id) }}">
                                                                    @method('POST')
                                                                    @csrf
                                                                    <button class="btn btn-danger" id="delete-record">Oui,
                                                                        desactiver</button>

                                                                </form>
                                                            @elseif ($cheque->status == DESACTIVE())
                                                                <form method="POST"
                                                                    action="{{ route('cheque.restore', $cheque->id) }}">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button type="submit" class="btn btn-danger"
                                                                        id="delete-record">Oui,
                                                                        restaurer</button>
                                                                </form>
                                                            @else
                                                                <form method="POST"
                                                                    action="{{ route('cheque.desactive', $cheque->id) }}">
                                                                    @method('POST')
                                                                    @csrf
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
                                    <div class="modal fade flip" id="SupprimeModal{{ $cheque->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                        colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px">
                                                    </lord-icon>
                                                    <div class="mt-4 text-center">

                                                        <h4>Vous êtes sur le point de supprimer <br>un <span
                                                                class="text-lowercase">{{ $cheque->NaturePaiement ?? 'Cheque' }}
                                                                ?</h4>
                                                        <p class="text-muted fs-15 mb-4">En supprimant @if ($cheque->NaturePaiement == 'ESPECE')
                                                                cet
                                                            @else
                                                                ce
                                                            @endif <span
                                                                class="text-lowercase">{{ $cheque->NaturePaiement ?? 'Cheque' }}</span>,
                                                            vous
                                                            supprimez
                                                            <br> toutes les informations le concernant de notre base de
                                                            données.
                                                        </p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Fermer</button>

                                                            <form method="POST"
                                                                action="{{ route('cheque.desactive', $cheque->id) }}">
                                                                @method('POST')
                                                                @csrf
                                                                <button class="btn btn-danger" id="delete-record">Oui,
                                                                    supprimer</button>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
