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
                    <h6 class="card-title m-0">Liste des paiements</h6>

                </div>
                <form action="#">

                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="entreprisesTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>Raison Social </th>
                                    <th>Libelle de taxe</th>
                                    <th>Reference</th>
                                    <th>Montant</th>
                                    <th>Moyen de Paiement</th>
                                    <th>Numero de Paiement</th>
                                    <th>Date de Paiement</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paiements as $ind => $paiement)
                                    <tr>
                                        <td>{{ $ind + 1 }}</td>
                                        <td>{{ $paiement->entreprise->raison_sociale ?? 'xxxxxxxxx' }}</td>
                                        <td>{{ $paiement->taxeEntreprise->periode ?? 'xxxxxxxxx' }}</td>
                                        <td>{{ $paiement->referencePaiement ?? ($paiement->codePaiement ?? 'xxxxxxxxx') }}
                                        </td>
                                        <td>{{ $paiement->montant ?? 'xxxxxxxxx' }} F CFA</td>
                                        <td>{{ $paiement->moyenPaiement ?? 'xxxxxxxxx' }}</td>
                                        <td>{{ $paiement->contactPaiement ?? 'xxxxxxxxx' }}</td>
                                        <td>{{ $paiement->datePaiement ?? 'xxxxxxxxx' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $paiement->status == 1 ? 'success' : 'danger' }}">
                                                {{ $paiement->status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('recuPay', $paiement->codePaiement) }}"
                                                    class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                    title="recu">
                                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20"
                                                        viewBox="0 0 512.000000 512.000000"
                                                        preserveAspectRatio="xMidYMid meet">

                                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                            fill="#000000" stroke="none">
                                                                                                                        <path d="M1680 4090 l0 -640 -600 0 -600 0 0 -1040 0 -1040 -240 0 -240 0 0
                                                                -75 0 -75 840 0 840 0 0 -412 0 -413 118 118 117 117 80 -80 80 -80 75 75 c41
                                                                41 80 75 85 75 5 0 45 -35 87 -77 l78 -78 80 80 80 80 80 -80 80 -80 80 80 80
                                                                80 80 -80 80 -80 80 80 80 80 80 -80 79 -79 77 83 77 83 119 -119 118 -118 0
                                                                413 0 412 685 0 685 0 0 75 0 75 -245 0 -245 0 0 1040 0 1040 -1400 0 -1400 0
                                                                0 565 0 565 885 0 885 0 0 -480 0 -480 75 0 75 0 0 555 0 555 -1035 0 -1035 0
                                                                0 -640z m-560 -1755 l0 -965 -245 0 -245 0 0 965 0 965 245 0 245 0 0 -965z
                                                                m3040 697 l0 -268 -40 -39 -40 -39 0 -351 0 -351 40 -39 40 -39 0 -268 0 -268
                                                                -205 0 -205 0 0 445 0 445 85 0 85 0 0 75 0 75 -1200 0 -1200 0 0 -75 0 -75
                                                                1040 0 1040 0 0 -752 0 -753 -42 43 -43 42 -77 -77 -78 -78 -80 80 -80 80 -80
                                                                -80 -80 -80 -80 80 -80 80 -80 -80 -80 -80 -80 80 -80 80 -80 -80 -80 -80 -80
                                                                80 -80 80 -79 -79 -80 -79 -83 76 -83 76 -42 -41 -43 -42 0 672 0 672 -75 0
                                                                -75 0 0 -365 0 -365 -205 0 -205 0 0 965 0 965 1445 0 1445 0 0 -268z m320
                                                                -697 l0 -965 -85 0 -85 0 0 298 0 298 -40 39 -40 39 0 291 0 291 40 39 40 39
                                                                0 298 0 298 85 0 85 0 0 -965z" />
                                                                                                                        <path
                                                                                                                            d="M800 2340 l0 -320 75 0 75 0 0 320 0 320 -75 0 -75 0 0 -320z" />
                                                                                                                        <path
                                                                                                                            d="M2000 2015 l0 -75 720 0 720 0 0 75 0 75 -720 0 -720 0 0 -75z" />
                                                                                                                        <path d="M3200 1735 l0 -45 -40 0 -40 0 0 -195 0 -195 80 0 80 0 0 -45 0 -45
                                                                -80 0 -80 0 0 -75 0 -75 40 0 40 0 0 -40 0 -40 75 0 75 0 0 40 0 40 40 0 40 0
                                                                0 195 0 195 -80 0 -80 0 0 45 0 45 85 0 85 0 0 75 0 75 -45 0 -45 0 0 45 0 45
                                                                -75 0 -75 0 0 -45z" />
                                                            <path
                                                                d="M2000 1695 l0 -75 480 0 480 0 0 75 0 75 -480 0 -480 0 0 -75z" />
                                                            <path
                                                                d="M2000 1375 l0 -75 480 0 480 0 0 75 0 75 -480 0 -480 0 0 -75z" />
                                                            <path
                                                                d="M2000 1055 l0 -75 480 0 480 0 0 75 0 75 -480 0 -480 0 0 -75z" />
                                                            <path
                                                                d="M2000 4335 l0 -75 80 0 80 0 0 75 0 75 -80 0 -80 0 0 -75z" />
                                                            <path
                                                                d="M2320 4335 l0 -75 560 0 560 0 0 75 0 75 -560 0 -560 0 0 -75z" />
                                                            <path
                                                                d="M2000 4015 l0 -75 80 0 80 0 0 75 0 75 -80 0 -80 0 0 -75z" />
                                                            <path
                                                                d="M2320 4015 l0 -75 560 0 560 0 0 75 0 75 -560 0 -560 0 0 -75z" />
                                                            <path
                                                                d="M2000 3695 l0 -75 80 0 80 0 0 75 0 75 -80 0 -80 0 0 -75z" />
                                                            <path
                                                                d="M2320 3695 l0 -75 560 0 560 0 0 75 0 75 -560 0 -560 0 0 -75z" />
                                                        </g>
                                                    </svg>

                                                </a>

                                            </div>
                                        </td>

                                    </tr>
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
