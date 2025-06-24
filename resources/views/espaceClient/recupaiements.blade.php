<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Paiements</title>
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Utilisez les styles de votre template existant ou ajoutez ceux-ci */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0fdf4;
            color: #003153;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #003153;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .card-header {
            background-color: #10b981;
            color: white;
            padding: 15px 20px;
            font-size: 1.2rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /*
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #003153;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #003153;
            color: white;
            border: 1px solid #003153;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        } */


        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            padding: 15px 0;
        }

        .pagination-links {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-link,
        .pagination span:not(.active) {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #003153;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: #f0f0f0;
        }

        .pagination .active {
            padding: 8px 15px;
            background-color: #003153;
            color: white;
            border-radius: 5px;
            border: 1px solid #003153;
        }

        .pagination .disabled {
            padding: 8px 15px;
            color: #999;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {

            .page-link,
            .pagination span {
                padding: 6px 10px;
                font-size: 0.9rem;
            }
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: #003153;
            color: white;
        }

        .btn-secondary {
            background-color: #d1fae5;
            color: #003153;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.9rem;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        /* @media (max-width: 768px) {

            th,
            td {
                padding: 8px 10px;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
            }
        } */
    </style>
</head>

<body>
    <div class="header">
        <div class="container header-content">
            <h1><i class="fas fa-file-invoice-dollar"></i> Historique des Paiements</h1>
            <div class="action-buttons">
                <a href="{{ route('espaceClient.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> Liste des paiements
            </div>

            <div class="card-body">
                @if ($paiements->count() > 0)
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Méthode</th>
                                    {{-- <th>Facture</th> --}}
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paiements as $paiement)
                                    <tr>
                                        {{-- @php
                                            dd($paiement);
                                        @endphp --}}
                                        <td>
                                            @if (!empty($paiement->taxe_entreprise_id))
                                                {{ $paiement->taxeEntreprise->periode ?? 'xxxxxxxx' }}
                                            @else
                                                Tout les Factures
                                            @endif
                                        </td>
                                        <td>{{ $paiement->referencePaiement ?? ($paiement->codePaiement ?? 'xxxxxx') }}
                                        </td>
                                        <td>{{ $paiement->datePaiement ?? $paiement->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            @if ($paiement->moyenPaiement == 'CHEQUE')
                                                <i class="fas fa-money-check-alt"></i> Chèque
                                            @elseif ($paiement->moyenPaiement == 'VIREMENT')
                                                <i class="fas fa-money-check-alt"></i> VIREMENT
                                            @else
                                                <i class="fas fa-mobile-alt"></i> Mobile
                                            @endif
                                        </td>
                                        {{-- <td>{{ $paiement->taxeEntreprise->numero_titre_facture ?? 'N/A' }}</td> --}}
                                        <td>
                                            @if ($paiement->status == 1)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Complet
                                                </span>
                                            @elseif($paiement->status == 2)
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-spinner"></i> En cours
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times-circle"></i> Échoué
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($paiement->status == 1)
                                                <a href="{{ route('recuPay', $paiement->codePaiement) }}"
                                                    class="btn btn-primary btn-sm" target="_target">
                                                    <i class="fas fa-receipt"></i> recu
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="pagination">
                        @if ($paiements->hasPages())
                            <div class="pagination-links">
                                @if ($paiements->onFirstPage())
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">&laquo; Précédent</span>
                                    </span>
                                @else
                                    <a href="{{ $paiements->previousPageUrl() }}" class="page-link"
                                        rel="prev">&laquo; Précédent</a>
                                @endif
                                @foreach ($paiements->getUrlRange(1, $paiements->lastPage()) as $page => $url)
                                    @if ($page == $paiements->currentPage())
                                        <span class="active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                    @endif
                                @endforeach
                                @if ($paiements->hasMorePages())
                                    <a href="{{ $paiements->nextPageUrl() }}" class="page-link" rel="next">Suivant
                                        &raquo;</a>
                                @else
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">Suivant &raquo;</span>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div> --}}
                    <div class="pagination">
                        @if ($paiements->hasPages())
                            <div class="pagination-links">
                                {{-- Previous Page Link --}}
                                @if ($paiements->onFirstPage())
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">&laquo; Précédent</span>
                                    </span>
                                @else
                                    <a href="{{ $paiements->url($paiements->currentPage() - 1) }}&cheques_page={{ $cheques->currentPage() }}"
                                        class="page-link" rel="prev">&laquo; Précédent</a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($paiements->getUrlRange(1, $paiements->lastPage()) as $page => $url)
                                    @if ($page == $paiements->currentPage())
                                        <span class="active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}&cheques_page={{ $cheques->currentPage() }}"
                                            class="page-link">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($paiements->hasMorePages())
                                    <a href="{{ $paiements->url($paiements->currentPage() + 1) }}&cheques_page={{ $cheques->currentPage() }}"
                                        class="page-link" rel="next">Suivant &raquo;</a>
                                @else
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">Suivant &raquo;</span>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <div class="no-data">
                        <i class="fas fa-info-circle fa-2x"></i>
                        <h3>Aucun paiement enregistré</h3>
                        <p>Vous n'avez effectué aucun paiement pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> Liste des cheques et Virements
            </div>

            <div class="card-body">
                @if ($cheques->count() > 0)
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>libelle</th>
                                    <th>Numero du cheque</th>
                                    <th>Banque</th>
                                    <th>Date</th>
                                    <th>Montant</th>

                                    <th>Titulaire</th>
                                    <th>Notes</th>
                                    <th>Nature</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cheques as $cheque)
                                    <tr>
                                        <td>
                                            @if (!empty($cheque->taxe_entreprise_id))
                                                {{ $cheque->taxeEntreprise->periode ?? 'xxxxxxxx' }}
                                            @else
                                                Tout les Factures
                                            @endif
                                        </td>
                                        <td>
                                            {{ $cheque->numero_cheque ?? 'xxxxxx' }}
                                        </td>
                                        <td>
                                            @if (!empty($cheque->autre_banque))
                                                {{ $cheque->autre_banque ?? 'xxxxxx' }}
                                            @else
                                                {{ $cheque->banque ?? 'xxxxxx' }}
                                            @endif
                                        </td>
                                        <td>{{ $cheque->date_emission ?? $cheque->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td>{{ number_format($cheque->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $cheque->titulaire ?? 'xxxxxxxx' }}
                                        </td>
                                        <td>{{ $cheque->notes ?? 'xxxxxxxx' }}
                                        </td>

                                        <td>
                                            @if ($cheque->NaturePaiement == 'CHEQUE')
                                                <i class="fas fa-money-check-alt"></i> Chèque
                                            @else
                                                <i class="fas fa-mobile-alt"></i> VIREMENT
                                            @endif
                                        </td>
                                        <td>{{ $cheque->motif_rejet ?? 'xxxxxxxx' }}
                                        </td>

                                        <td>
                                            @if ($cheque->status == 1)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> valide
                                                </span>
                                            @elseif($cheque->status == 2)
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-spinner"></i> En cours
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times-circle"></i> Échoué
                                                </span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if ($cheque->status == 1)
                                                <a href="{{ route('recuPay', $paiement->codePaiement) }}"
                                                    class="btn btn-primary btn-sm" target="_target">
                                                    <i class="fas fa-receipt"></i> recu
                                                </a>
                                            @endif
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="pagination">
                        @if ($cheques->hasPages())
                            <div class="pagination-links">
                                @if ($cheques->onFirstPage())
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">&laquo; Précédent</span>
                                    </span>
                                @else
                                    <a href="{{ $cheques->previousPageUrl() }}" class="page-link"
                                        rel="prev">&laquo; Précédent</a>
                                @endif
                                @foreach ($cheques->getUrlRange(1, $cheques->lastPage()) as $page => $url)
                                    @if ($page == $cheques->currentPage())
                                        <span class="active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                    @endif
                                @endforeach
                                @if ($cheques->hasMorePages())
                                    <a href="{{ $cheques->nextPageUrl() }}" class="page-link" rel="next">Suivant
                                        &raquo;</a>
                                @else
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">Suivant &raquo;</span>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div> --}}

                    <div class="pagination">
                        @if ($cheques->hasPages())
                            <div class="pagination-links">
                                @if ($cheques->onFirstPage())
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">&laquo; Précédent</span>
                                    </span>
                                @else
                                    <a href="?paiements_page={{ $paiements->currentPage() }}&cheques_page={{ $cheques->currentPage() - 1 }}"
                                        class="page-link" rel="prev">&laquo; Précédent</a>
                                @endif
                                @foreach ($cheques->getUrlRange(1, $cheques->lastPage()) as $page => $url)
                                    @if ($page == $cheques->currentPage())
                                        <span class="active">{{ $page }}</span>
                                    @else
                                        <a href="?paiements_page={{ $paiements->currentPage() }}&cheques_page={{ $page }}"
                                            class="page-link">{{ $page }}</a>
                                    @endif
                                @endforeach
                                @if ($cheques->hasMorePages())
                                    <a href="?paiements_page={{ $paiements->currentPage() }}&cheques_page={{ $cheques->currentPage() + 1 }}"
                                        class="page-link" rel="next">Suivant &raquo;</a>
                                @else
                                    <span class="disabled" aria-disabled="true">
                                        <span class="page-link">Suivant &raquo;</span>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <div class="no-data">
                        <i class="fas fa-info-circle fa-2x"></i>
                        <h3>Aucun paiement de cheque et Virement enregistré</h3>
                        <p>Vous n'avez effectué aucun paiement en cheque ou Virement pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
