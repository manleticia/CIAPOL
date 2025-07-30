<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reçu de Paiement</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .receipt-container {
            max-width: 620px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
        }

        .receipt-header h1 {
            margin: 0;
            font-size: 28px;
            color: var(--primary-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--secondary-color), transparent);
            margin: 15px 0;
            border: none;
        }

        .section-title {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
            position: relative;
        }

        .section-title:after {
            content: "";
            display: block;
            width: 50px;
            height: 2px;
            background: var(--secondary-color);
            margin: 5px auto;
        }

        .receipt-details {
            margin-bottom: 25px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        .detail-value {
            text-align: right;
            font-weight: 500;
        }

        .amount-highlight {
            font-size: 20px;
            color: var(--accent-color);
            font-weight: 700;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            z-index: 0;
            pointer-events: none;
        }

        .watermark img {
            width: 400px;
            height: auto;
        }

        .qr-container {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        .receipt-footer a {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .receipt-footer a:hover {
            text-decoration: underline;
        }

        .print-button {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            padding: 10px 25px;
            background: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-button:hover {
            background: #2980b9;
            transform: translateX(-50%) translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .print-button:active {
            transform: translateX(-50%) translateY(1px);
        }

        .stamp {
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.8;
            width: 80px;
            height: 80px;
            border: 3px solid var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-weight: bold;
            transform: rotate(15deg);
            font-size: 12px;
            text-align: center;
            line-height: 1.2;
        }

        @media print {
            .print-button {
                display: none;
            }

            body {
                background: none;
                padding: 0;
                margin: 0;
            }

            .receipt-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
                max-width: 100%;
                border-radius: 0;
            }
        }

        @media (max-width: 768px) {
            .receipt-container {
                padding: 20px;
                margin: 15px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-value {
                text-align: left;
                margin-top: 3px;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="watermark">
            <img src="{{ asset('photos/logo.png') }}" alt="Logo CIAPOL">
        </div>

        <div class="stamp">
           <br> PAYÉ <br>{{ convertir_date( $paiement->datePaiement) ?? date('d/m/Y H:i') }}
        </div>

        <div class="receipt-header">
            <h1>Reçu de Paiement</h1>
        </div>

        <hr class="divider">

        <div class="receipt-details">
            <h3 class="section-title">Informations</h3>

            <div class="detail-row">
                <span class="detail-label">Raison sociale :</span>
                <span class="detail-value text-uppercase">{{ $infos->raison_sociale ?? 'XXXXXXXXXXX' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Téléphone :</span>
                <span class="detail-value">{{ $infos->telephone ?? 'XXXXXXXXXXX' }}</span>
            </div>
        </div>

        <hr class="divider">

        <div class="receipt-details">
            <h3 class="section-title">Détails du paiement</h3>

            <div class="detail-row">
                <span class="detail-label">Référence :</span>
                <span class="detail-value" style="color: var(--accent-color);">
                    @if (!empty($paiement->referencePaiement))
                        {{ $paiement->referencePaiement ?? 'XXXXXXXXXXX' }}
                    @else
                        {{ $paiement->codePaiement ?? 'XXXXXXXXXXX' }}
                    @endif
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Date de paiement :</span>
                <span class="detail-value">{{ convertir_date($paiement->datePaiement) ?? date('d/m/Y H:i') }}</span>
            </div>

            @if (!empty($paiement->contactPaiement))
            <div class="detail-row">
                <span class="detail-label">Contact :</span>
                <span class="detail-value">{{ $paiement->contactPaiement ?? 'XXXXXXXXXXX' }}</span>
            </div>
            @endif

            @if (!empty($paiement->moyenPaiement))
            <div class="detail-row">
                <span class="detail-label">Moyen de paiement :</span>
                <span class="detail-value">{{ $paiement->moyenPaiement ?? 'XXXXXXXXXXX' }}</span>
            </div>
            @endif

            <div class="detail-row">
                <span class="detail-label">Montant :</span>
                <span class="detail-value amount-highlight">{{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Nature du paiement :</span>
                <span class="detail-value">
                    @if ($paiement->entite)
                        {{ $paiement->entite ?? 'XXXXXXXXXXX' }}
                    @endif
                </span>
            </div>

            @if (!empty($paiement->taxeEntreprise->periode))
            <div class="detail-row">
                <span class="detail-label">Période :</span>
                <span class="detail-value">{{ $paiement->taxeEntreprise->periode ?? 'Total' }}</span>
            </div>
            @endif
        </div>

        <div class="qr-container">
            {!! QrCode::size(120)->generate($code) !!}
            <p class="mt-2">Code de vérification</p>
        </div>

        <hr class="divider">

        <div class="receipt-footer">
            <p>Ce reçu atteste que la somme mentionnée ci-dessus a été reçue.</p>
            <p>
                <strong>CIAPOL</strong> - Abidjan Cocody Centre Château<br>
                Abidjan B.P V 327 - Tél.: (225) 07 17 370 113<br>
                Email : <a href="mailto:ciapol@gmail.com">ciapol@gmail.com</a> -
                Site web : <a href="https://www.ciapol.ci">www.ciapol.ci</a>
            </p>
            <p class="text-muted">Reçu généré le : {{ date('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <button class="print-button" id="printButton">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1"/>
            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
        </svg>
        Imprimer le reçu
    </button>

    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
