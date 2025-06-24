<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement Réussi | Paiement par Chèque</title>
     <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --success: #4cc9f0;
            --success-dark: #38b6db;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--dark);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .success-container {
            max-width: 650px;
            width: 100%;
            animation: fadeIn 0.8s ease forwards;
        }

        .success-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            text-align: center;
            padding-bottom: 2rem;
        }

        .success-header {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            color: white;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .success-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
        }

        .success-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            animation: bounce 1s ease;
        }

        .success-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .success-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .success-body {
            padding: 0 2rem;
        }

        .receipt {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: left;
            border-left: 4px solid var(--success);
        }

        .receipt h3 {
            color: var(--success-dark);
            margin-bottom: 1rem;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .receipt h3 i {
            font-size: 1.5rem;
        }

        .receipt-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .detail-item {
            margin-bottom: 1rem;
        }

        .detail-label {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 0.3rem;
        }

        .detail-value {
            font-weight: 500;
            font-size: 1.05rem;
            word-break: break-word;
        }

        .amount-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            margin: 1.5rem 0;
            border: 2px dashed #ced4da;
        }

        .amount-display .label {
            font-size: 1rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
        }

        .amount-display .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--success-dark);
        }

        .next-steps {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            text-align: left;
        }

        .next-steps h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .next-steps h3 i {
            color: var(--success-dark);
        }

        .step {
            display: flex;
            margin-bottom: 1rem;
            align-items: flex-start;
        }

        .step-number {
            background: var(--success);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .step-content {
            padding-top: 0.1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(58, 12, 163, 0.3);
        }

        .btn-outline {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-print {
            background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
            color: white;
        }

        .btn-print:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(45, 55, 72, 0.3);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .receipt-details {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .success-header {
                padding: 2rem 1rem;
            }

            .success-body {
                padding: 0 1rem;
            }

            .success-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Enregistrement Réussi !</h1>
                <p>Votre {{ $cheque->NaturePaiement ?? "chèque" }}  a été enregistré avec succès sur notre plateforme CIAPOL</p>
            </div>

            <div class="success-body">
                <div class="receipt" id="printableArea">
                    <h3><i class="fas fa-receipt"></i> Reçu d'enregistrement</h3>
                    @php
                        // dd($cheque);
                    @endphp
                    <div class="amount-display">
                        <div class="label">MONTANT DU {{ $cheque->NaturePaiement ?? "chèque" }}</div>
                        <div class="value">{{ number_format($cheque->montant, 0, ',', ' ') }} FCFA</div>
                    </div>

                    <div class="receipt-details">
                        <div class="detail-item">
                            <div class="detail-label">Numéro du <span style="text-transform: lowercase;">{{ $cheque->NaturePaiement ?? "chèque" }}</span></div>
                            <div class="detail-value">{{ $cheque->numero_cheque }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Banque émettrice</div>
                            <div class="detail-value">
                                {{ $cheque->banque }}{{ isset($cheque->autre_banque) ? ' (' . $cheque->autre_banque . ')' : '' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Date d'émission</div>
                            <div class="detail-value">{{ date('d/m/Y', strtotime($cheque->date_emission)) }}</div>
                        </div>
                        {{-- @php
                            dd($cheque);
                        @endphp --}}
                        <div class="detail-item">
                            <div class="detail-label">Nom du titulaire du compte</div>
                            <div class="detail-value">{{ $cheque->titulaire ?? "xxxxxxxxx" }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Date d'enregistrement</div>
                            <div class="detail-value">{{  date('d/m/Y H:i',strtotime($cheque->created_at) ) }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Statut</div>
                            <div class="detail-value" style="color: var(--success-dark); font-weight: 600;">
                                <i class="fas fa-check-circle"></i> Enregistré
                            </div>
                        </div>
                    </div>
                </div>

                <div class="next-steps">
                    <h3><i class="fas fa-clipboard-list"></i> Prochaines étapes</h3>

                    <div class="step">
                        <span class="step-number">1</span>
                        <div class="step-content">
                            <strong>Imprimez ce reçu</strong>
                            <p>Conservez une copie pour vos archives et joignez-en une à votre envoi.</p>
                        </div>
                    </div>

                    <div class="step">
                        <span class="step-number">2</span>
                        <div class="step-content">
                            <strong>Envoyez votre <span style="text-transform: lowercase;">{{ $cheque->NaturePaiement ?? "chèque" }}</span></strong>
                            <p>Adressez votre <span style="text-transform: lowercase;">{{ $cheque->NaturePaiement ?? "chèque" }}</span> accompagné de ce reçu à notre service financier :</p>
                            <p style="margin-top: 0.5rem; font-style: italic;">
                                Service Comptabilité - Plateforme<br>
                              Angre 7eme tranche, Abidjan Cocody<br>
                                Côte d'Ivoire
                            </p>
                        </div>
                    </div>

                    <div class="step">
                        <span class="step-number">3</span>
                        <div class="step-content">
                            <strong>Confirmation finale</strong>
                            <p>Vous recevrez une notification par email lorsque le <span style="text-transform: lowercase;">{{ $cheque->NaturePaiement ?? "chèque" }}</span> sera encaissé et votre compte
                                crédité (délai de 48h ouvrées).</p>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button onclick="printDiv();" class="btn btn-print">
                        <i class="fas fa-print"></i> Imprimer le reçu
                    </button>
                    <a href="{{ route('espaceClient.index') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt"></i> Tableau de bord
                    </a>
                    {{-- <a href="#" class="btn btn-outline">
                        <i class="fas fa-history"></i> Voir mes transactions
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animation pour l'impression
        document.addEventListener('DOMContentLoaded', function() {
            // Ajout d'un effet de confetti visuel
            const colors = ['#4361ee', '#4cc9f0', '#3a0ca3', '#4895ef'];

            function createConfetti() {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.borderRadius = '50%';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = '-10px';
                confetti.style.opacity = '0.7';
                confetti.style.zIndex = '9999';
                confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';
                document.body.appendChild(confetti);

                let position = -10;
                let rotation = Math.random() * 360;
                const speed = 2 + Math.random() * 3;
                const spin = Math.random() > 0.5 ? 1 : -1;

                const fall = setInterval(() => {
                    position += speed;
                    rotation += spin;
                    confetti.style.top = position + 'px';
                    confetti.style.transform = 'rotate(' + rotation + 'deg)';

                    if (position > window.innerHeight) {
                        clearInterval(fall);
                        confetti.remove();
                    }
                }, 20);
            }

            // Lancer quelques confettis au chargement
            for (let i = 0; i < 50; i++) {
                setTimeout(createConfetti, i * 100);
            }

            // Style pour l'impression
            const style = document.createElement('style');
            style.innerHTML = `
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    .success-card, .success-card * {
                        visibility: visible;
                    }
                    .success-card {
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                        box-shadow: none;
                    }
                    .action-buttons {
                        display: none !important;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>



    <script>
        function printDiv() {
            // Créer un contenu HTML complet pour l'impression
            const printContent = `
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Reçu d'enregistrement de chèque</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    :root {
                        --primary: #4361ee;
                        --primary-dark: #3a0ca3;
                        --success: #4cc9f0;
                        --success-dark: #38b6db;
                        --light: #f8f9fa;
                        --dark: #212529;
                        --gray: #6c757d;
                    }

                    body {
                        font-family: 'Poppins', sans-serif;
                        color: var(--dark);
                        line-height: 1.6;
                        padding: 20px;
                        background: white !important;
                    }

                    .receipt {
                        background: #f8f9fa;
                        border-radius: 12px;
                        padding: 1.5rem;
                        margin-bottom: 2rem;
                        text-align: left;
                        border-left: 4px solid var(--success-dark);
                        max-width: 100%;
                    }

                    .receipt h3 {
                        color: var(--success-dark);
                        margin-bottom: 1rem;
                        font-size: 1.3rem;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    }

                    .receipt h3 i {
                        font-size: 1.5rem;
                    }

                    .receipt-details {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 1rem;
                    }

                    .detail-item {
                        margin-bottom: 1rem;
                    }

                    .detail-label {
                        font-size: 0.85rem;
                        color: var(--gray);
                        margin-bottom: 0.3rem;
                    }

                    .detail-value {
                        font-weight: 500;
                        font-size: 1.05rem;
                        word-break: break-word;
                    }

                    .amount-display {
                        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                        border-radius: 10px;
                        padding: 1.5rem;
                        text-align: center;
                        margin: 1.5rem 0;
                        border: 2px dashed #ced4da;
                    }

                    .amount-display .label {
                        font-size: 1rem;
                        color: var(--gray);
                        margin-bottom: 0.5rem;
                    }

                    .amount-display .value {
                        font-size: 2rem;
                        font-weight: 700;
                        color: var(--success-dark);
                    }

                    .next-steps {
                        background: #f8f9fa;
                        border-radius: 12px;
                        padding: 1.5rem;
                        margin-top: 2rem;
                        text-align: left;
                        page-break-inside: avoid;
                    }

                    .next-steps h3 {
                        color: var(--dark);
                        margin-bottom: 1rem;
                        font-size: 1.2rem;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    }

                    .next-steps h3 i {
                        color: var(--success-dark);
                    }

                    .step {
                        display: flex;
                        margin-bottom: 1rem;
                        align-items: flex-start;
                        page-break-inside: avoid;
                    }

                    .step-number {
                        background: var(--success);
                        color: white;
                        width: 24px;
                        height: 24px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 1rem;
                        flex-shrink: 0;
                        font-size: 0.8rem;
                        font-weight: 600;
                    }

                    .step-content {
                        padding-top: 0.1rem;
                    }

                    @media print {
                        @page {
                            size: auto;
                            margin: 10mm;
                        }
                        body {
                            padding: 0;
                            background: white;
                        }
                        .receipt, .next-steps {
                            break-inside: avoid;
                        }
                        .action-buttons {
                            display: none !important;
                        }
                    }

                    @media (max-width: 768px) {
                        .receipt-details {
                            grid-template-columns: 1fr;
                        }
                    }
                </style>
            </head>
            <body>
                ${document.querySelector('.receipt').outerHTML}
                ${document.querySelector('.next-steps').outerHTML}

                <div style="text-align: center; margin-top: 2rem; font-size: 0.9rem; color: var(--gray);">
                    <p>Reçu généré le ${new Date().toLocaleDateString('fr-FR', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</p>
                </div>
            </body>
            </html>
        `;

            // Ouvrir une nouvelle fenêtre pour l'impression
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(printContent);
            printWindow.document.close();

            // Attendre que le contenu soit chargé avant d'imprimer
            printWindow.onload = function() {
                setTimeout(function() {
                    printWindow.print();
                    // Ne pas fermer immédiatement pour permettre à l'utilisateur de voir l'aperçu
                    // printWindow.close();
                }, 500);
            };
        }
    </script>
</body>

</html>
