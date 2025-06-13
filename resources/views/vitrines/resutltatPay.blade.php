<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statut de transaction</title>
     <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .status-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            text-align: center;
            position: relative;
            max-width: 500px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .status-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .status-icon {
            width: 150px;
            height: 150px;
            margin: 0 auto 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            position: relative;
        }

        .success-icon {
            background-color: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
            border: 4px solid #4CAF50;
            animation: pulse 2s infinite;
        }

        .failure-icon {
            background-color: rgba(229, 62, 62, 0.1);
            color: rgba(229, 62, 62, 0.951);
            border: 4px solid rgba(229, 62, 62, 0.951);
            animation: shake 0.5s ease;
        }

        .status-icon i {
            font-size: 70px;
        }

        .status-content {
            margin-bottom: 30px;
        }

        .status-content h1 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #333;
        }

        .status-content p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .code-display {
            display: inline-block;
            background: #f5f5f5;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: bold;
            margin: 10px 0;
            font-size: 20px;
            color: #444;
        }

        .success-code {
            color: #4CAF50;
        }

        .failure-code {
            color: rgba(229, 62, 62, 0.951);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: linear-gradient(to right, #4CAF50, #2E7D32);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #43A047, #1B5E20);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(to right, #607D8B, #455A64);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(to right, #546E7A, #37474F);
            box-shadow: 0 5px 15px rgba(96, 125, 139, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #607D8B;
            color: #607D8B;
        }

        .btn-outline:hover {
            background: #607D8B;
            color: white;
        }

        .transaction-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
            text-align: left;
        }

        .transaction-details h3 {
            margin-bottom: 15px;
            color: #444;
            display: flex;
            align-items: center;
        }

        .transaction-details h3 i {
            margin-right: 10px;
            color: #4CAF50;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #777;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        /* Animations */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.4);
            }
            70% {
                box-shadow: 0 0 0 20px rgba(76, 175, 80, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0);
            }
        }

        @keyframes shake {
            0%, 100% {transform: translateX(0);}
            20%, 60% {transform: translateX(-10px);}
            40%, 80% {transform: translateX(10px);}
        }

        .bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% {transform: translateY(0);}
            50% {transform: translateY(-10px);}
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .status-container {
                padding: 30px 20px;
            }

            .status-icon {
                width: 120px;
                height: 120px;
            }

            .status-icon i {
                font-size: 50px;
            }

            .status-content h1 {
                font-size: 26px;
            }

            .status-content p {
                font-size: 16px;
            }

            .actions {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .status-icon {
                width: 100px;
                height: 100px;
            }

            .status-icon i {
                font-size: 40px;
            }

            .status-content h1 {
                font-size: 22px;
            }

            .code-display {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <input type="text"  id="Code" value="{{ $code }}" hidden>
    <input type="text"  id="messagApi" value="{{ $mess }}" hidden>
    <div class="status-container">
        <!-- Icône de statut dynamique -->
        <div class="status-icon" id="statusIcon">
            <i id="statusSymbol"></i>
        </div>

        <div class="status-content">
            <h1 id="statusTitle">Statut de la transaction</h1>
            <p id="statusMessage">Chargement des informations...</p>
            <div class="code-display" id="codeDisplay">
                Code: <span id="statusCode"></span>
            </div>
        </div>

        <div class="transaction-details">
            <h3><i class="fas fa-receipt"></i> Détails de la transaction</h3>
            <div class="detail-item">
                <span class="detail-label">ID de transaction:</span>
                <span class="detail-value">{{$paiement->codePaiement ?? 'xxxxxxx'}} </span>
            </div>
            {{-- <div class="detail-item">
                <span class="detail-label">Date & heure:</span>
                <span class="detail-value"><?php echo date('d M Y, H:i'); ?></span>
            </div> --}}
            <div class="detail-item">
                <span class="detail-label">Montant:</span>
                <span class="detail-value">{{$paiement->montant ?? 'xxxxxxx'}}  F CFA</span>
            </div>
            @if ($code == 200)
            <div class="detail-item">
                <span class="detail-label">Méthode de paiement:</span>
                <span class="detail-value">{{$paiement->moyenPaiement ?? 'xxxxxxx'}} </span>
            </div>

            @endif

        </div>

        <div class="actions">
            <a href="{{route('espaceClient.index')}}" class="btn btn-primary" target="_target">
                <i class="fas fa-home"></i> Retour à mon espace
            </a>
            @if ($code == 200)
            <a href="{{ route('recuPay',$paiement->codePaiement) }}" class="btn btn-secondary" target="_target">
                <i class="fas fa-download"></i> Télécharger le reçu
            </a>
            @endif
        </div>
    </div>

    <script>
        // Fonction pour configurer l'affichage en fonction du statut
        function setStatus() {
            // Récupération des éléments
            const icon = document.getElementById('statusIcon');
            const symbol = document.getElementById('statusSymbol');
            const title = document.getElementById('statusTitle');
            const message = document.getElementById('statusMessage');
            const code = document.getElementById('statusCode');
            let status = document.getElementById('Code').value;
            const mess = document.getElementById('messagApi').value;
            const codeDisplay = document.getElementById('codeDisplay');

            // Simulation des données de statut


            if (status == 200) {
                // Configuration pour succès
                icon.classList.add('success-icon', 'bounce');
                symbol.className = 'fas fa-check-circle';

                title.textContent = 'Transaction Réussie!';
                message.textContent = mess;
                code.textContent = status;
                codeDisplay.classList.add('success-code');
            } else {
                // Configuration pour échec
                icon.classList.add('failure-icon');
                symbol.className = 'fas fa-times-circle';

                title.textContent = 'Transaction Échouée!';
                message.textContent = mess;
                code.textContent = status;
                codeDisplay.classList.add('failure-code');
            }
        }

        // Appeler la fonction au chargement de la page
        window.onload = setStatus;
    </script>
</body>
</html>
