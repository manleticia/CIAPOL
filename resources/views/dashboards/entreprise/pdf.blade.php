<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $libelle ?? 'liste des ' }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            position: relative;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
        }

        .watermark img {
            width: 500px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
            page-break-inside: auto;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-primary {
            background-color: #007bff;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="watermark">
        <img src="{{ asset('photos/logo.png') }}" alt="Logo CIAPOL">
    </div>

    <h2>{{ $libelle ?? 'liste des entreprises' }} <span><i>de CIAPOL</i></span></h2>

    @if ($pas == 1)
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="30%">Raison Sociale</th>
                    <th width="20%">Inspection</th>
                    <th width="15%">Téléphone</th>
                    <th width="15%">Téléphone 2</th>
                    <th width="15%">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entreprises as $index => $entreprise)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $entreprise->raison_sociale }}</td>
                        <td>{{ $entreprise->inspection }}</td>
                        <td>{{ $entreprise->telephone }}</td>
                        <td>{{ $entreprise->telephone_2 }}</td>
                        <td>
                            <span class="badge bg-{{ $entreprise->status ? 'success' : 'danger' }}">
                                {{ $entreprise->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($pas == 2)
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Raison Sociale</th>
                    <th width="15%">Libellé de taxe</th>
                    <th width="10%">Référence</th>
                    <th width="10%">Montant</th>
                    <th width="10%">Moyen de Paiement</th>
                    <th width="10%">Numéro de Paiement</th>
                    <th width="10%">Date de Paiement</th>
                    <th width="10%">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entreprises as $index => $paiement)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $paiement->entreprise->raison_sociale ?? 'N/A' }}</td>
                        <td>{{ $paiement->taxeEntreprise->periode ?? 'N/A' }}</td>
                        <td>{{ $paiement->referencePaiement ?? ($paiement->codePaiement ?? 'N/A') }}</td>
                        <td>{{ number_format($paiement->montant ?? 0, 0, ',', ' ') }} F CFA</td>
                        <td>{{ $paiement->moyenPaiement ?? 'N/A' }}</td>
                        <td>{{ $paiement->contactPaiement ?? 'N/A' }}</td>
                        <td>{{ $paiement->datePaiement ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $paiement->status ? 'success' : 'danger' }}">
                                {{ $paiement->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($pas == 3)
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Raison Sociale</th>
                    <th width="15%">Libellé de taxe</th>
                    <th width="10%">Nature</th>
                    <th width="10%">Numéro du Chèque</th>
                    <th width="10%">Montant</th>
                    <th width="10%">Banque</th>
                    <th width="10%">Titulaire</th>
                    <th width="10%">Date émission</th>
                    <th width="10%">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entreprises as $index => $cheque)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $cheque->entreprise->raison_sociale ?? 'N/A' }}</td>
                        <td>{{ $cheque->taxeEntreprise->periode ?? 'TOUT' }}</td>
                        <td>{{ $cheque->NaturePaiement ?? 'N/A' }}</td>
                        <td>{{ $cheque->numero_cheque ?? 'N/A' }}</td>
                        <td>{{ number_format($cheque->montant ?? 0, 0, ',', ' ') }} F CFA</td>
                        <td>
                            @if (!empty($cheque->autre_banque))
                                {{ $cheque->autre_banque ?? 'N/A' }}
                            @else
                                {{ $cheque->banque ?? ($cheque->autre_banque ?? 'N/A') }}
                            @endif
                        </td>
                        <td>{{ $cheque->titulaire ?? 'N/A' }}</td>
                        <td>{{ $cheque->date_emission ?? 'N/A' }}</td>
                        <td>
                            @if ($cheque->status == 1)
                                <span class="badge bg-success">Valide</span>
                            @elseif($cheque->status == 2)
                                <span class="badge bg-primary">Attente</span>
                            @else
                                <span class="badge bg-danger">Refusé</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Généré le {{ date('d/m/Y à H:i') }} - © CIAPOL
    </div>
</body>

</html>
