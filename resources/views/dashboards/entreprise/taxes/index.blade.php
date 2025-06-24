@extends('layouts.dashboard', ['title' => 'Entreprise Taxe  - TABLEAU DE BORD'])
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
                    <h6 class="card-title m-0">Liste des Taxe de l'entreprise {{ $libelle ?? 'xxxxxxxx' }}</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{ route('entreprises.index') }}" class="btn btn-primary d-inline">Retour</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="entreprisesTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>Periode</th>
                                    <th>Titre Facture</th>
                                    <th>Localisation</th>
                                    <th>Montant</th>

                                    <th>Statut</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taxes as $ind => $entreprise)
                                    <tr>
                                        @php
                                            // dd($entreprise)
                                        @endphp
                                        <td>{{ $ind + 1 }}</td>
                                        <td>{{ $entreprise->periode ?? "xxxxxxx" }}</td>
                                        <td>{{ $entreprise->numero_titre_facture ?? "xxxxxxx" }}</td>
                                        <td>{{ $entreprise->localisation }}</td>
                                        <td> {{ number_format($entreprise->montant, 0, ',', ' ') }} FCFA</td>


                                        <td>
                                            <span class="badge bg-{{ $entreprise->status == 1 ? 'success' : 'danger' }}">
                                                {{ $entreprise->status == 1 ? 'Payer' : 'Impayer' }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" class="btn btn-sm btn-outline-info"
                                                    data-bs-toggle="tooltip" title="Voir">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="tooltip" title="Modifier">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="#"
                                                    class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                    title="Facture">
                                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                                        width="20" height="20"
                                                        viewBox="0 0 512.000000 512.000000"
                                                        preserveAspectRatio="xMidYMid meet">

                                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                            fill="#000000" stroke="none">
                                                            <path d="M773 5106 c-94 -30 -179 -110 -210 -199 -17 -50 -18 -161 -18 -2347
                                                        0 -2194 1 -2297 18 -2347 24 -70 93 -145 165 -180 l57 -28 1775 0 1775 0 57
                                                        28 c72 35 141 110 165 180 16 48 18 94 18 560 l0 509 -24 19 c-32 26 -73 24
                                                        -99 -4 -22 -23 -22 -24 -22 -508 -1 -509 -3 -532 -47 -581 -10 -11 -36 -29
                                                        -58 -39 -38 -18 -112 -19 -1765 -19 -1653 0 -1727 1 -1765 19 -49 22 -73 48
                                                        -91 98 -20 57 -20 4529 0 4586 18 50 42 76 91 98 36 17 70 19 326 19 274 0
                                                        287 1 313 21 36 28 36 80 0 108 -26 20 -38 21 -323 20 -214 0 -308 -4 -338
                                                        -13z" />
                                                                    <path d="M1652 5113 c-21 -8 -43 -61 -36 -88 15 -58 -68 -55 1359 -55 1250 0
                                                        1312 -1 1350 -19 22 -10 48 -28 58 -39 48 -53 46 6 47 -1748 l0 -1651 23 -21
                                                        c29 -27 67 -28 98 -3 l24 19 0 1674 c0 1592 -1 1676 -18 1725 -24 70 -93 145
                                                        -165 180 l-57 28 -1335 2 c-734 1 -1341 -1 -1348 -4z" />
                                                                    <path d="M1020 4692 l-30 -30 0 -231 c0 -227 0 -230 23 -257 31 -35 82 -38
                                                        109 -5 16 21 18 45 18 261 0 261 -2 271 -62 286 -22 5 -33 0 -58 -24z" />
                                                                    <path d="M1323 4710 c-39 -16 -43 -39 -43 -283 0 -213 2 -237 18 -258 25 -30
                                                        75 -30 105 0 19 18 23 36 27 121 l5 99 65 -96 c36 -52 76 -106 89 -119 31 -32
                                                        75 -31 106 1 l25 24 0 230 c0 126 -3 237 -6 246 -10 24 -60 46 -89 39 -45 -11
                                                        -55 -39 -55 -153 l0 -105 -79 115 c-44 63 -85 120 -93 126 -21 17 -51 22 -75
                                                        13z" />
                                                                    <path d="M1830 4707 c-53 -27 -51 -50 30 -290 41 -121 85 -232 96 -246 26 -31
                                                        83 -34 113 -7 13 12 49 106 98 251 76 229 77 233 59 259 -24 38 -60 50 -96 31
                                                        -24 -13 -34 -32 -70 -140 -23 -69 -43 -125 -45 -125 -2 0 -11 24 -20 53 -47
                                                        142 -75 204 -101 215 -31 15 -33 15 -64 -1z" />
                                                                    <path d="M2467 4710 c-62 -16 -112 -47 -155 -95 -97 -111 -96 -263 4 -374 134
                                                        -149 370 -117 467 64 31 58 31 193 -1 252 -61 115 -198 181 -315 153z m131
                                                        -167 c58 -37 78 -121 42 -180 -32 -52 -65 -67 -143 -64 -39 1 -93 57 -102 104
                                                        -9 48 -1 78 31 116 42 50 115 60 172 24z" />
                                                                    <path d="M2964 4697 l-29 -25 0 -241 c0 -234 1 -241 22 -262 27 -27 75 -29
                                                        103 -4 19 17 20 30 20 265 0 222 -2 248 -17 263 -33 29 -68 31 -99 4z" />
                                                                    <path d="M3418 4706 c-130 -36 -210 -141 -210 -277 0 -161 119 -281 280 -282
                                                        56 -1 76 4 121 28 53 29 91 73 91 106 0 9 -9 28 -21 43 -28 35 -76 35 -119 0
                                                        -55 -47 -145 -29 -184 36 -36 62 -8 165 52 188 58 23 72 23 118 3 58 -26 75
                                                        -26 108 0 34 27 36 77 3 107 -52 49 -160 71 -239 48z" />
                                                                    <path d="M3821 4684 c-20 -25 -21 -39 -21 -254 0 -295 -9 -280 165 -280 122 0
                                                        124 0 144 26 27 35 26 57 -3 90 -20 24 -32 28 -90 32 -66 4 -67 5 -64 31 3 24
                                                        7 26 63 29 73 4 95 21 95 72 0 51 -25 71 -99 77 -55 5 -61 8 -61 28 0 21 6 23
                                                        66 27 58 4 70 8 90 32 29 33 30 55 3 90 -20 26 -22 26 -144 26 -122 0 -124 0
                                                        -144 -26z" />
                                                                    <path d="M3100 3810 c-30 -30 -27 -83 6 -109 26 -21 36 -21 490 -21 318 0 471
                                                        3 487 11 24 11 47 47 47 73 0 7 -9 25 -21 40 l-20 26 -485 0 c-471 0 -485 -1
                                                        -504 -20z" />
                                                                    <path
                                                                        d="M3615 3475 c-14 -13 -25 -31 -25 -40 0 -29 29 -72 52 -79 30 -8 406
                                                        -8 436 0 23 7 52 50 52 79 0 9 -11 27 -25 40 l-24 25 -221 0 -221 0 -24 -25z" />
                                                                    <path d="M1183 3055 c-27 -16 -49 -40 -62 -68 -21 -43 -21 -52 -21 -861 0
                                                        -782 1 -818 19 -854 24 -47 50 -70 98 -88 50 -17 788 -20 826 -3 24 11 47 47
                                                        47 73 0 7 -9 25 -21 40 l-20 26 -388 0 c-288 0 -390 3 -399 12 -9 9 -12 69
                                                        -12 210 l0 198 945 0 945 0 0 -210 0 -210 -430 0 c-417 0 -431 -1 -450 -20
                                                        -28 -28 -26 -75 5 -105 l24 -25 788 0 c833 1 834 1 885 47 11 10 29 35 39 55
                                                        19 37 19 68 17 866 l-3 828 -25 37 c-13 20 -41 45 -61 56 -37 21 -44 21 -1370
                                                        21 l-1334 0 -42 -25z m1957 -330 l0 -205 -945 0 -945 0 0 198 c0 109 3 202 7
                                                        205 3 4 429 7 945 7 l938 0 0 -205z m728 -2 l2 -203 -285 0 -285 0 0 205 0
                                                        205 283 -2 282 -3 3 -202z m-728 -593 l0 -240 -945 0 -945 0 0 240 0 240 945
                                                        0 945 0 0 -240z m730 0 l0 -240 -285 0 -285 0 0 240 0 240 285 0 285 0 0 -240z
                                                        m-67 -397 l67 -6 0 -193 c0 -143 -3 -195 -12 -201 -7 -4 -136 -9 -285 -11
                                                        l-273 -4 0 211 0 211 218 0 c119 0 247 -3 285 -7z" />
                                                                    <path d="M3065 756 c-22 -13 -65 -57 -95 -98 -38 -50 -63 -74 -80 -76 -37 -5
                                                        -70 -41 -70 -74 0 -38 40 -78 77 -78 65 1 112 36 211 159 18 22 42 41 52 41
                                                        13 0 39 -26 75 -74 60 -82 100 -112 162 -122 79 -12 142 24 216 125 69 94 80
                                                        94 152 -3 30 -41 69 -83 87 -94 74 -45 146 -36 169 20 17 43 -3 78 -58 98 -31
                                                        11 -53 30 -86 75 -76 103 -111 125 -195 125 -66 0 -116 -33 -182 -122 -31 -40
                                                        -63 -74 -72 -76 -17 -3 -23 2 -99 97 -65 80 -89 94 -162 99 -52 3 -68 -1 -102
                                                        -22z" />
                                                        </g>
                                                    </svg>


                                                </a>
                                            </div>
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
