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
                    {{-- <div>
                        <a href="{{ route('entreprises.import') }}" class="btn btn-success">
                            <i class="fas fa-file-import me-2"></i>Importer
                        </a>
                    </div> --}}
                </div>
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
                                        <td>{{ $paiement->taxeEntreprise->semestre_depose ?? 'xxxxxxxxx' }}</td>
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
                                                <a href="#" class="btn btn-sm btn-outline-info"
                                                    data-bs-toggle="tooltip" title="Voir">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            
                                            </div>

                                        </td>
                                        {{-- <td>{{ $entreprise->secteur_numero_rapport }}</td>
                                        <td>{{ $entreprise->inspection }}</td>
                                        <td>{{ $entreprise->lieu_de_depot }}</td>
                                        <td>{{ $entreprise->telephone }}</td>
                                        <td>{{ $entreprise->telephone_2 }}</td>
                                        <td>
                                            <span class="badge bg-{{ $entreprise->status == 1 ? 'success' : 'danger' }}">
                                                {{ $entreprise->status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($entreprise->status == 2)
                                                <div class="btn-group" role="group">
                                                    <a href="#" class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="tooltip" title="Voir">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="tooltip" title="Modifier">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="{{ route('entreprises.taxes.index', $entreprise->id) }}"
                                                        class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                        title="Taxe">
                                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                            width="20" height="20"
                                                            viewBox="0 0 512.000000 512.000000"
                                                            preserveAspectRatio="xMidYMid meet">
                                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                                fill="#000000" stroke="none">
                                                                <path
                                                                    d="M329 5106 c-58 -20 -97 -54 -129 -109 l-30 -52 0 -192 c0 -180 1
                                                                    -194 20 -213 22 -22 60 -26 90 -10 31 17 40 67 40 229 1 163 4 176 47 199 16
                                                                    9 404 12 1537 12 l1515 0 28 -24 28 -24 3 -1243 2 -1242 -68 -71 c-38 -39 -81
                                                                    -90 -96 -112 l-27 -42 -39 42 -39 41 -143 3 c-129 2 -146 1 -176 -18 -62 -38
                                                                    -72 -69 -72 -216 0 -119 2 -134 23 -164 44 -66 66 -75 193 -78 l114 -4 0 -89
                                                                    0 -89 -108 0 c-122 0 -161 -14 -199 -70 -21 -30 -23 -44 -23 -168 0 -119 2
                                                                    -138 21 -169 36 -58 81 -73 214 -73 130 0 167 10 206 58 l26 30 44 -60 c24
                                                                    -33 67 -82 96 -108 l53 -49 0 -161 0 -162 -29 -29 -29 -29 -1525 0 c-1486 0
                                                                    -1525 0 -1548 19 l-24 19 -5 1792 -5 1792 -28 24 c-34 29 -56 30 -91 3 l-26
                                                                    -20 0 -1802 0 -1801 21 -43 c25 -53 86 -106 138 -121 21 -7 103 -12 185 -12
                                                                    l146 0 0 -138 c0 -160 14 -223 62 -278 56 -64 97 -78 238 -82 116 -3 127 -2
                                                                    147 18 31 28 31 82 1 110 -19 17 -35 20 -119 20 -169 0 -181 14 -177 213 l3
                                                                    132 1325 5 c1468 6 1348 0 1417 69 55 55 67 94 71 234 2 70 6 127 8 127 3 0
                                                                    21 -8 42 -19 54 -27 158 -59 235 -72 l67 -11 0 -293 c0 -188 -4 -303 -11 -324
                                                                    -23 -65 58 -61 -1326 -61 -1016 -1 -1261 -3 -1275 -14 -39 -30 -40 -92 0 -122
                                                                    14 -11 255 -13 1282 -14 842 0 1277 4 1302 10 56 16 119 69 147 125 l26 49 3
                                                                    323 3 322 37 6 c20 4 71 15 112 25 327 81 586 357 657 698 21 105 13 319 -16
                                                                    417 -49 164 -132 297 -259 416 -127 119 -274 194 -439 226 l-92 17 -3 901 c-3
                                                                    888 -3 901 -24 945 -23 50 -80 105 -130 126 -24 10 -79 14 -188 14 l-154 0 -4
                                                                    163 c-3 143 -6 167 -25 202 -28 52 -67 89 -123 114 -45 20 -57 21 -1580 20
                                                                    -1229 0 -1542 -2 -1571 -13z m3603 -647 c48 -26 48 -18 48 -953 l0 -874 -55
                                                                    -7 c-72 -9 -171 -37 -240 -69 l-55 -25 0 970 0 969 141 0 c81 0 149 -5 161
                                                                    -11z m353 -2012 c114 -38 197 -90 291 -182 92 -91 150 -182 190 -300 36 -106
                                                                    45 -285 20 -398 -58 -261 -261 -476 -526 -559 -108 -33 -311 -33 -420 0 -246
                                                                    77 -433 263 -510 507 -31 100 -38 267 -15 371 62 283 268 498 550 575 106 29
                                                                    310 22 420 -14z m-1135 -387 l0 -90 -90 0 -90 0 0 90 0 90 90 0 90 0 0 -90z
                                                                    m0 -660 l0 -90 -90 0 -90 0 0 90 0 90 90 0 90 0 0 -90z" />
                                                                <path d="M3639 2206 c-95 -34 -159 -125 -159 -226 0 -127 113 -240 240 -240
                                                                    126 0 240 114 240 242 0 159 -170 278 -321 224z m142 -165 c20 -20 29 -39 29
                                                                    -61 0 -43 -47 -90 -90 -90 -43 0 -90 47 -90 90 0 43 47 90 90 90 22 0 41 -9
                                                                    61 -29z" />
                                                                <path
                                                                    d="M4263 2213 c-23 -9 -533 -869 -533 -898 0 -28 40 -75 64 -75 46 0 68
                                                                    32 319 450 186 310 257 437 257 459 0 51 -56 85 -107 64z" />
                                                                <path d="M4285 1701 c-89 -40 -139 -119 -140 -221 0 -53 5 -73 28 -112 84
                                                                    -144 269 -166 384 -46 109 113 72 308 -70 377 -55 27 -146 28 -202 2z m160
                                                                    -156 c47 -46 22 -134 -41 -149 -37 -10 -82 11 -99 45 -21 40 -19 63 11 98 34
                                                                    41 92 44 129 6z" />
                                                                <path d="M605 4765 c-14 -13 -25 -36 -25 -50 0 -14 11 -37 25 -50 21 -22 33
                                                                    -25 90 -25 l65 0 0 -304 c0 -292 1 -304 21 -330 26 -33 79 -36 109 -6 19 19
                                                                    20 33 20 330 l0 310 64 0 c81 0 95 6 111 43 16 39 3 80 -31 96 -16 7 -97 11
                                                                    -225 11 -199 0 -200 0 -224 -25z" />
                                                                <path d="M1569 4775 c-15 -8 -33 -31 -41 -52 -110 -278 -248 -655 -248 -676 0
                                                                    -37 33 -67 72 -67 43 0 63 21 89 96 l23 65 149 -3 150 -3 21 -57 c28 -73 51
                                                                    -98 92 -98 34 0 74 37 74 69 0 16 -228 627 -256 687 -24 50 -75 66 -125 39z
                                                                    m90 -365 c23 -58 41 -108 41 -112 0 -5 -40 -8 -89 -8 l-89 0 38 98 c20 53 40
                                                                    106 44 116 3 10 8 17 10 15 3 -2 23 -51 45 -109z" />
                                                                <path d="M2166 4769 c-47 -37 -37 -69 65 -214 50 -72 93 -135 96 -142 3 -7
                                                                    -43 -81 -102 -164 -130 -183 -137 -198 -109 -236 22 -29 50 -39 88 -29 14 3
                                                                    58 57 120 145 54 77 102 138 106 136 4 -3 45 -58 90 -122 46 -65 92 -128 103
                                                                    -140 26 -29 79 -31 107 -3 38 38 26 68 -80 219 -55 79 -107 153 -115 165 -14
                                                                    21 -10 30 85 166 60 85 100 152 100 167 0 30 -42 73 -70 73 -38 0 -58 -19
                                                                    -140 -136 -45 -64 -85 -112 -90 -107 -4 4 -39 54 -79 110 -96 138 -122 154
                                                                    -175 112z" />
                                                                <path d="M585 3610 c-72 -37 -80 -56 -83 -215 -3 -133 -2 -142 20 -175 50 -75
                                                                    -19 -70 1049 -70 l956 0 33 23 c63 42 75 76 75 217 0 115 -2 128 -24 164 -15
                                                                    24 -40 45 -65 57 -39 18 -86 19 -981 19 -924 0 -941 0 -980 -20z m1895 -220
                                                                    l0 -90 -915 0 -915 0 0 90 0 90 915 0 915 0 0 -90z" />
                                                                <path d="M2901 3608 c-70 -37 -81 -69 -81 -223 0 -146 11 -177 72 -215 29 -17
                                                                    51 -20 164 -20 119 0 134 2 164 23 65 44 75 66 79 193 4 138 -11 189 -67 232
                                                                    -34 26 -42 27 -161 30 -116 3 -129 1 -170 -20z m249 -218 l0 -90 -90 0 -90 0
                                                                    0 90 0 90 90 0 90 0 0 -90z" />
                                                                <path d="M615 2963 c-31 -8 -83 -51 -100 -83 -11 -21 -15 -63 -15 -158 0 -117
                                                                    2 -132 23 -162 12 -19 38 -43 57 -54 35 -21 47 -21 955 -24 622 -2 936 1 971
                                                                    8 52 11 88 39 113 88 17 32 25 146 16 226 -6 58 -12 73 -42 107 -20 22 -50 43
                                                                    -71 49 -37 10 -1866 13 -1907 3z m1865 -238 l0 -95 -915 0 -915 0 0 95 0 95
                                                                    915 0 915 0 0 -95z" />
                                                                <path d="M2926 2960 c-16 -5 -40 -19 -53 -32 -47 -43 -53 -68 -53 -206 0 -117
                                                                    2 -132 23 -162 42 -63 76 -75 217 -75 113 0 129 2 162 23 60 37 78 88 78 218
                                                                    0 94 -3 116 -22 154 -36 70 -71 85 -208 87 -63 1 -128 -2 -144 -7z m219 -235
                                                                    l0 -90 -87 -3 -88 -3 0 96 0 96 88 -3 87 -3 0 -90z" />
                                                                <path
                                                                    d="M572 2280 c-61 -38 -72 -69 -72 -216 0 -119 2 -134 23 -164 12 -18
                                                                    35 -43 50 -54 28 -21 32 -21 979 -24 946 -2 951 -2 994 19 26 12 53 36 66 57
                                                                    21 33 23 49 23 162 0 141 -12 175 -75 217 l-33 23 -961 0 c-941 0 -962 0 -994
                                                                    -20z m1908 -220 l0 -90 -915 0 -915 0 0 90 0 90 915 0 915 0 0 -90z" />
                                                                <path d="M582 1623 c-19 -9 -44 -32 -58 -52 -22 -33 -24 -44 -24 -166 0 -151
                                                                    12 -185 76 -222 l39 -23 960 3 960 2 33 23 c57 41 67 72 67 212 0 138 -11 171
                                                                    -68 214 -28 21 -30 21 -990 23 -876 2 -965 1 -995 -14z m1898 -223 l0 -90
                                                                    -915 0 -915 0 0 90 0 90 915 0 915 0 0 -90z" />
                                                            </g>
                                                        </svg>

                                                    </a>
                                                </div>
                                            @endif
                                        </td> --}}
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
