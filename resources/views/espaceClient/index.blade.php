<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Paiement Factures</title>
     <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset et styles de base */
        .factures-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .facture-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .facture-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
        }

        .facture-details {
            padding: 15px 20px;
        }

        .facture-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }

        .facture-item:last-child {
            border-bottom: none;
        }

        .facture-actions {
            padding: 15px 20px;
            background: #f8f9fa;
            text-align: right;
        }

        .btn-payer {
            background-color: #003153;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-payer:hover {
            background-color: #004080;
        }

        .montant-total {
            font-weight: bold;
            color: #003153;
            font-size: 1.1em;
        }

        .payment-options {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .payment-title {
            color: #2d3748;
            font-size: 1.2rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .payment-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .payment-btn {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .payment-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .payment-btn:hover::before {
            left: 100%;
        }

        .payment-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cheque-btn {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
        }

        .mobile-btn {
            background: linear-gradient(135deg, #702cdf 0%, #702cdf 100%);
            color: white;
        }

        .btn-icon {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 40px;
            text-align: center;
        }

        .btn-content {
            flex: 1;
        }

        .btn-main-text {
            display: block;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .btn-sub-text {
            display: block;
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .btn-arrow {
            margin-left: 10px;
            transition: transform 0.3s ease;
        }

        .payment-btn:hover .btn-arrow {
            transform: translateX(5px);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0fdf4;
            color: #003153;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background-color: #003153;
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(4, 120, 87, 0.2);
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Boutons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            background-color: #ffffff;
            color: ##003153;
            font-weight: bold;
        }

        .pay-btn {
            background-color: #003153;
            color: white;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-secondary {
            background-color: #d1fae5;
            color: #003153;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        /* Section utilisateur */
        .user-info {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(4, 120, 87, 0.1);
            position: relative;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 5px solid #a7f3d0;
        }

        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info h2 {
            font-size: 28px;
            margin-bottom: 5px;
            color: #064e3b;
        }

        .user-info p {
            font-size: 18px;
            color: #4b5563;
        }

        /* Cards */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(4, 120, 87, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #d1fae5;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(4, 120, 87, 0.1);
        }

        .card-header {
            background-color: #10b981;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }

        .card-header i {
            font-size: 24px;
            margin-right: 15px;
        }

        .card-header h3 {
            font-size: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            margin-bottom: 10px;
            color: #4b5563;
        }

        .card-body strong {
            color: #064e3b;
        }

        /* Facture */
        .facture-section {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            box-shadow: 0 4px 6px rgba(4, 120, 87, 0.1);
        }

        .facture-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #d1fae5;
            padding-bottom: 15px;
        }

        .facture-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .facture-item {
            margin-bottom: 15px;
        }

        .facture-total {
            font-size: 20px;
            font-weight: bold;
            color: #064e3b;
            margin-top: 20px;
            text-align: right;
            border-top: 2px solid #d1fae5;
            padding-top: 15px;
        }

        /* Footer */
        footer {
            background-color: #003153;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #64748b;
        }

        .modal h2 {
            margin-bottom: 20px;
            color: #064e3b;
        }

        .modal p {
            margin-bottom: 25px;
            color: #4b5563;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }






        /* Responsive */
        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: 1fr;
            }

            header .container {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .action-buttons {
                width: 100%;
                justify-content: center;
            }

            .facture-details {
                grid-template-columns: 1fr;
            }

            .modal-buttons {
                flex-direction: column;
            }

            .modal-buttons button {
                width: 100%;
            }
        }
    </style>


    <style>
        /* Style pour les nouveaux boutons */
        .btn-secondary {
            background-color: #d1fae5;
            color: #003153;
            border: 1px solid #a7f3d0;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #a7f3d0;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Ajustement pour l'espacement des boutons */
        .action-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Responsive pour les petits écrans */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .action-buttons .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

</head>

<body>
    {{-- <header>
        <div class="container">
            <h1><i class="fas fa-file-invoice-dollar"></i> Paiement Factures</h1>
            <div class="action-buttons">

                <a href="#" id="logout-btn" class="btn logout-btn"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </header> --}}
    <header>
        <div class="container">
            <h1><i class="fas fa-file-invoice-dollar"></i> Paiement Factures</h1>
            <div class="action-buttons">
                <!-- Nouveaux boutons ajoutés ici -->
                {{-- <a href="#" class="btn btn-secondary">
                    <i class="fas fa-history"></i> Voir mes transactions
                </a> --}}
                <a href="{{ route('espaceClient.mesrecus',$us->id) }}" class="btn btn-secondary">
                    {{-- <i class="fas fa-receipt"></i> Voir mes reçus --}}
                       <i class="fas fa-history"></i> Voir mes transactions
                </a>

                <a href="#" id="logout-btn" class="btn logout-btn"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </header>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}

        </div>
    @endif

    <main class="container">
        <div class="user-info">
            <div class="profile-pic">
                <div id="company-avatar"
                    style="width:150px; height:150px; background:#003153; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:50px; margin:0 auto 20px;">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <h2 id="user-name">{{ $us->raison_sociale ?? 'xxxxx' }}</h2>
            <p id="user-email">{{ $us->telephone }}
                @if ($us->telephone_2)
                    / {{ $us->telephone_2 }}
                @endif
            </p>
        </div>

        <!-- Section Facture -->
        <div class="facture-section">
            <div class="facture-header">
                <h2><i class="fas fa-file-invoice"></i>Les Facture de l'entreprise : {{ $us->raison_sociale }}</h2>

            </div>
            <table>

            </table>

            <div class="facture-details">
                <div>
                    <div class="facture-item">
                        <strong>date:</strong>{{ dateFr1(date('d/m/Y')) }}
                    </div>
                    <div class="facture-item">
                        <strong>Telephone:</strong> {{ $us->telephone ?? 'xxxxxxxx' }}
                    </div>

                </div>
                <div>
                    <div class="facture-item">
                        <strong>Service:</strong> paiement de facture
                    </div>
                    {{-- <div class="facture-item">
                        <strong>Agent Programme:</strong> {{ $us->agent_programme ?? '' }}
                    </div> --}}

                </div>
            </div>
            @foreach ($valeurs as $value)
            @php
                // dd($value);
            @endphp
                <div class="factures-container">
                    <h2><i class="fas fa-file-invoice"></i> {{ $value->periode ?? "xxxxxxxx" }} </h2>

                    <div class="facture-card">
                        <div class="facture-header">
                            <div class="row jsustify-content-between align-items-center">
                                <div class="col-6">
                                    <h3><strong>NUMERO TITRE FACTURE : {{ $value->numero_titre_facture ?? "xxxxxxx" }}
                                        </strong>
                                    </h3>
                                </div>
                                <div class="col-6">
                                    <h3>
                                        <strong>LOCALISATION:</strong> {{ $value->localisation ?? "xxxxxxx" }}
                                    </h3>
                                </div>
                                {{-- <div class="col-6">
                                    <h3>

                                        <strong> Date depot taxe :</strong>{{ $value->annee_depot_taxe }}
                                    </h3>
                                </div> --}}
                            </div>


                        </div>

                        <div class="facture-details">

                            <div class="facture-item">
                                <span><strong> {{ $value->periode  ?? "xxxxxx" }}</strong></span>
                                <span> <strong> {{ $value->montant ?? "xxxxxx" }} FCFA </strong></span>
                            </div>

                        </div>

                        <div class="facture-actions">
                            <div class="facture-total ">
                                <div class="row">
                                    <div class="col-6">
                                        {{-- <a href="" class="btn pay-btn">
                                            <i class="fas fa-eye"></i> Detail
                                        </a> --}}

                                    </div>
                                    <div class="col-6">
                                        <strong>Montant total:</strong> {{ $value->montant }} Fcfa <br>
                                        <a href="#" class="btn pay-btn"
                                            data-target="payment-modal{{ $value->id }}">
                                            <i class="fas fa-credit-card"></i> Payer Facture
                                        </a>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>





                <!-- Modal de paiement -->
                <div id="payment-modal{{ $value->id }}" class="modal">
                    <div class="modal-content">
                        <span href="    " class="close-btn">&times;</span>
                        <h2><i class="fas fa-credit-card"></i> Paiement de Facture</h2>

                        <div style="margin: 20px 0; padding: 15px; background-color: #ecfdf5; border-radius: 8px;">
                            <p><strong>Facture : {{ $value->periode ?? "xxxxxx" }} </strong></p>
                            <p><strong>N° titre facture : {{ $value->numero_titre_facture ?? "xxxxxx" }} </strong></p>
                            <p>Montant à payer: <strong> {{ $value->montant }} Fcfa</strong></p>


                        </div>

                        <div class="payment-methods mt-4">
                            <h4>Choisissez votre mode de paiement :</h4>

                            <div class="payment-options">
                                <div class="payment-buttons">
                                    <!-- Bouton Paiement par chèque -->
                                    <form action="{{ route('espaceClient.cheques') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <input type="text" name="idtaxe" value="{{ $value->id }}" hidden>

                                        <input type="text" name="montant" value="{{ $value->montant }}" hidden>
                                        <button type="submit" class="payment-btn mobile-btn">
                                            <div class="btn-icon">
                                                <i class="fas fa-money-check-alt"></i>
                                            </div>
                                            <div class="btn-content">
                                                <span class="btn-main-text">Payer par Chèque ou Virement</span>
                                                <span class="btn-sub-text">qui sera remis a notre agent</span>
                                            </div>
                                            <div class="btn-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </div>
                                        </button>
                                    </form>

                                    <form action="{{ route('paiementHub') }}" method="POST"
                                        class="payment-btn mobile-btn">
                                        @csrf
                                        @method('POST')
                                        <input type="text" name="montant" value="{{ $value->montant }}" hidden>
                                        <input type="text" name="idtaxe" value="{{ $value->id }}" hidden>
                                        <button type="submit" class="payment-btn mobile-btn">
                                            <div class="btn-icon">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                            <div class="btn-content">
                                                <span class="btn-main-text">Paiement Mobile</span>
                                                <span class="btn-sub-text">Paiement instantané via le Hub</span>


                                            </div>
                                            <div class="btn-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="facture-total">
                <strong>Montant total:</strong> {{ $sommeMontants }} Fcfa <br>
                <button id="pay-btn" class="btn pay-btn">
                    <i class="fas fa-credit-card"></i> Tout payer
                </button>
            </div>

        </div>


        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 Paiement Factures. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Modal Paiement -->



    <div id="payment-mod" class="modal">
        <div class="modal-content">
            <span href="    " class="close-btn">&times;</span>
            <h2><i class="fas fa-credit-card"></i> Paiement de Facture</h2>

            <div style="margin: 20px 0; padding: 15px; background-color: #ecfdf5; border-radius: 8px;">
                <p><strong>Facture de Tout mes Taxes </strong></p>
                <p>Montant à payer: <strong> {{ $sommeMontants }} Fcfa</strong></p>

            </div>

            <div class="payment-methods mt-4">
                <h4>Choisissez votre mode de paiement :</h4>

                <div class="payment-options">
                    <div class="payment-buttons">
                        <form action="{{ route('espaceClient.cheques') }}" method="post" >
                            @csrf
                            @method('POST')
                            <input type="text" name="montant" value="{{ $sommeMontants }}" hidden>

                            <button type="submit" class="payment-btn cheque-btn">
                                <div class="btn-icon">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <div class="btn-content">
                                    <span class="btn-main-text">Payer par Chèque ou Virement</span>
                                    <span class="btn-sub-text">qui sera remis a notre agent</span>
                                </div>
                                <div class="btn-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </button>


                        </form>

                        <form action="{{ route('paiementHub') }}" method="POST" class="payment-btn mobile-btn">
                            {{-- {{ route('payment.mobile', $us->id) }} --}}
                            @csrf
                            @method('POST')
                            <!-- Champ caché pour le montant -->
                            <input type="text" name="montant" value="{{ $sommeMontants }}" hidden>
                            <!-- Bouton Paiement via le hubb -->

                            <button type="submit" class="payment-btn mobile-btn">
                                <div class="btn-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="btn-content">
                                    <span class="btn-main-text">Payer via le hubb</span>
                                    <span class="btn-sub-text">Paiement instantané</span>
                                </div>
                                <div class="btn-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payBtn = document.getElementById('pay-btn');
            const modal = document.getElementById('payment-mod');
            const closeBtn = modal.querySelector('.close-btn');

            // Ouvrir la modale
            payBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
            });

            // Fermer la modale en cliquant sur (×)
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Fermer si on clique en dehors
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>












    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ouvrir la modale
            document.querySelectorAll('.pay-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const modal = document.getElementById(targetId);
                    if (modal) {
                        modal.style.display = 'flex';
                    }
                });
            });

            // Fermer la modale via le bouton (x)
            document.querySelectorAll('.close-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const modal = this.closest('.modal');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                });
            });

            // Fermer en cliquant à l'extérieur de la modale
            window.addEventListener('click', function(e) {
                document.querySelectorAll('.modal').forEach(function(modal) {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Éléments du DOM
            const payBtn = document.getElementById('pay-btn');
            const logoutBtn = document.getElementById('logout-btn');
            const paymentModal = document.getElementById('payment-modal');
            const logoutModal = document.getElementById('logout-modal');
            const confirmPayment = document.getElementById('confirm-payment');
            const cancelPayment = document.getElementById('cancel-payment');
            const confirmLogout = document.getElementById('confirm-logout');
            const cancelLogout = document.getElementById('cancel-logout');
            const closeBtns = document.querySelectorAll('.close-btn');

            // Simuler des données utilisateur


            // Remplir les informations utilisateur
            function populateUserData() {
                document.getElementById('user-name').textContent = userData.name;
                document.getElementById('user-email').textContent = userData.email;
                document.getElementById('user-avatar').src = userData.avatar;
                document.getElementById('user-address').textContent = userData.address;
                document.getElementById('user-phone').textContent = userData.phone;
                document.getElementById('user-since').textContent = userData.memberSince;
                document.getElementById('user-card').textContent = userData.card;
                document.getElementById('card-expiry').textContent = userData.cardExpiry;
            }

            // Gestion des modals
            function showModal(modal) {
                modal.style.display = 'flex';
            }

            function hideModal(modal) {
                modal.style.display = 'none';
            }

            function performPayment() {
                // Logique de paiement
                alert('Paiement effectué avec succès !');
                hideModal(paymentModal);
                // Ici vous pourriez actualiser l'interface ou rediriger
            }

            function performLogout() {
                // Logique de déconnexion
                alert('Déconnexion réussie. Redirection vers la page de connexion...');
                // window.location.href = 'login.html';
            }

            // Événements
            payBtn.addEventListener('click', () => showModal(paymentModal));
            logoutBtn.addEventListener('click', () => showModal(logoutModal));

            confirmPayment.addEventListener('click', performPayment);
            cancelPayment.addEventListener('click', () => hideModal(paymentModal));

            confirmLogout.addEventListener('click', performLogout);
            cancelLogout.addEventListener('click', () => hideModal(logoutModal));

            closeBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const modal = this.closest('.modal');
                    hideModal(modal);
                });
            });

            // Fermer les modals en cliquant à l'extérieur
            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal')) {
                    hideModal(event.target);
                }
            });

            // Initialiser la page
            populateUserData();
        });
    </script>
</body>

</html>
