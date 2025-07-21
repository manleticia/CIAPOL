@extends('layouts.dashboard', ['title' => $title ?? 'Liste des cheques'])
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
                    <h6 class="card-title m-0">Liste des paiements</h6>
                    <div>
                        <a href="{{ route('cheque.create') }}" class="btn btn-success">
                            <i class="fas fa-file-import me-2"></i>Enregistre un chéque ou virement
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
                                            @else
                                                <span class="badge bg-danger">
                                                    {{-- {{ $cheque->status == 1 ? 'Active' : 'Inactive' }} --}}
                                                    Refuse
                                                </span>
                                            @endif
                                        </td>
                                        <td>

                                            <div class="btn-group" role="group">
                                                <a href="{{ route('detail.cheques', $cheque->id) }}"
                                                    class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                    title="Voir">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                            </div>
                                            <div class="btn-group" role="group">
                                                @if ($cheque->status == 2)
                                                    <a href="{{ route('cheque.edit', $cheque->id) }}"
                                                        class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                        title="Voir">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="btn-group" role="group">
                                                @if ($cheque->status == 2)
                                                    <a href="#deleteModal{{ $cheque->id }}"
                                                        class="btn btn-link btn-sm text-danger deleteIcon  btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Supprimer"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            </div>

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
                                                            <h4>Vous êtes sur le point de supprimer <br>un chèque ?</h4>
                                                            <p class="text-muted fs-15 mb-4">En supprimant ce chèque, vous
                                                                supprimez
                                                                <br> toutes les informations le concernant de notre base de
                                                                données.
                                                            </p>
                                                        @else
                                                            <h4>Vous êtes sur le point de restaurer <br>un chèque ?</h4>
                                                            <p class="text-muted fs-15 mb-4">En restaurant ce chèque,
                                                                vous
                                                                le
                                                                remettez dans la liste des chèques en attente.
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
                                                                    action="{{ route('cheque.desactive', $cheque->id) }}">
                                                                    @method('POST')
                                                                    @csrf
                                                                    <button class="btn btn-danger" id="delete-record">Oui,
                                                                        supprimer</button>

                                                                </form>
                                                            @else
                                                                <form method="POST" action="#">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button type="submit" class="btn btn-danger"
                                                                        id="delete-record">Oui,
                                                                        restaurer</button>
                                                                </form>
                                                            @endif
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
