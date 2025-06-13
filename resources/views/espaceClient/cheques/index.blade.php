<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement par Chèque | Plateforme</title>
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f72585;
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
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .payment-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(50, 50, 93, 0.15), 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .payment-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .payment-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
        }

        .payment-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }

        .payment-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.8rem;
            position: relative;
        }

        .payment-header p {
            opacity: 0.9;
            margin-top: 0.5rem;
            font-size: 0.95rem;
        }

        .payment-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary);
            background-color: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }

        .amount-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 1.2rem;
            text-align: center;
            border: 2px dashed #ced4da;
            margin-bottom: 1.5rem;
        }

        .amount-display .label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.3rem;
        }

        .amount-display .value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 1rem;
            width: 100%;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(58, 12, 163, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .payment-steps {
            margin-top: 2.5rem;
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid var(--primary);
        }

        .payment-steps h3 {
            margin-bottom: 1rem;
            color: var(--primary-dark);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-steps h3 i {
            color: var(--primary);
        }

        .step {
            display: flex;
            margin-bottom: 1.2rem;
            align-items: flex-start;
        }

        .step:last-child {
            margin-bottom: 0;
        }

        .step-number {
            background: var(--primary);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .step-content {
            padding-top: 0.2rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            margin-top: 1.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .back-link:hover {
            color: var(--primary-dark);
            background-color: rgba(67, 97, 238, 0.1);
        }

        .form-note {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.5rem;
            display: block;
        }

        .required-field::after {
            content: " *";
            color: var(--danger);
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

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

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .container {
                padding: 1rem;
            }

            .payment-header {
                padding: 1.5rem 1rem;
            }

            .payment-body {
                padding: 1.5rem;
            }
        }

        /* Validation styles */
        .is-invalid {
            border-color: var(--danger) !important;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 0.3rem;
            display: block;
        }

        /* Checkbox style */
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-check-input {
            width: auto;
            margin-right: 0.5rem;
        }

        .form-check-label {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="payment-card fade-in">
            <div class="payment-header">
                <i class="fas fa-money-check-alt"></i>
                <h2>Enregistrement de Paiement </h2>
                <p>Sécurisé et simple - Validez votre transaction en 3 étapes</p>
            </div>

            <div class="payment-body">
                <form action="{{ route('espaceClient.cheques.enregistre') }}" method="POST" id="cheque-form">
                    @csrf
                    <div class="amount-display">
                        <div class="label">Montant total à régler <br>
                            <p> {{ $libelle ?? '' }}</p>
                        </div>
                        <div class="value">{{ number_format($montant, 0, ',', ' ') }} FCFA</div>
                        <input type="hidden" name="montant" value="{{ $montant }}">
                    </div>
                    @if (!empty($valeur))
                        <input type="text" name="idTaxe" id="" value="{{ $valeur->id }}" hidden>
                    @endif


                    <div class="form-group">
                        <label for="banque-select" class="required-field">Nature</label>
                        <select id="NaturePaiement" name="NaturePaiement" required>
                            <option value="">-- Sélectionnez la nature --</option>
                            <option value="CHEQUE">Chèque</option>
                            <option value="VIREMENT">Virement</option>

                        </select>
                    </div>


                    <div class="form-group">
                        <label for="numero_cheque" class="required-field">Numéro du chèque</label>
                        <div class="input-wrapper">
                            <input type="text" id="numero_cheque" name="numero_cheque" required
                                pattern="[A-Za-z0-9-]+" title="Caractères alphanumériques et tirets uniquement"
                                placeholder="CHQ-2023-001">
                            <i class="fas fa-hashtag input-icon"></i>
                        </div>
                        <span class="form-note">Ex: CHQ-2023-001 ou 2023/CHQ/001</span>
                    </div>

                    <div class="form-group">
                        <label for="banque-select" class="required-field">Banque émettrice</label>
                        <select id="banque-select" name="banque" required>
                            <option value="">-- Sélectionnez votre banque --</option>
                            <option value="BOA">Bank of Africa (BOA)</option>
                            <option value="ECOBANK">Ecobank</option>
                            <option value="UBA">United Bank for Africa (UBA)</option>
                            <option value="NSIA">Banque NSIA</option>
                            <option value="SGBCI">Société Générale Côte d'Ivoire (SGBCI)</option>
                            <option value="BICICI">BICICI</option>
                            <option value="SIB">Société Ivoirienne de Banque (SIB)</option>
                            <option value="OTHER">Autre banque</option>
                        </select>
                    </div>

                    <div id="autre-banque-container" class="form-group" style="display: none;">
                        <label for="autre-banque" class="required-field">Précisez votre banque</label>
                        <input type="text" id="autre-banque" name="autre_banque"
                            placeholder="Nom complet de votre banque">
                    </div>

                    <div class="form-group">
                        <label for="date_emission" class="required-field">Date d'émission</label>
                        <input type="date" id="date_emission" name="date_emission" required max="{{ date('Y-m-d') }}"
                            value="{{ old('date_emission', date('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label for="titulaire">Nom du titulaire du compte</label>
                        <input type="text" id="titulaire" name="titulaire"
                            placeholder="Nom tel qu'il apparaît sur le chèque">
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes complémentaires</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Référence client, informations supplémentaires...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="conditions" required>
                        <label class="form-check-label" for="conditions">Je certifie que les informations fournies sont
                            exactes et que le chèque sera honoré</label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check-circle"></i> Valider l'enregistrement
                        </button>
                    </div>
                </form>

                <div class="payment-steps">
                    <h3><i class="fas fa-info-circle"></i> Procédure de paiement</h3>
                    <div class="step">
                        <span class="step-number">1</span>
                        <div class="step-content">
                            <strong>Enregistrement</strong>
                            <p>Remplissez ce formulaire et imprimez le bordereau de confirmation qui s'affichera après
                                validation.</p>
                        </div>
                    </div>
                    <div class="step">
                        <span class="step-number">2</span>
                        <div class="step-content">
                            <strong>Envoi du chèque</strong>
                            <p>Envoyez votre chèque accompagné du bordereau à notre service financier à l'adresse :</p>
                            <p><em>Service Comptabilité - Angre 7eme tranche, Abidjan, Côte d'Ivoire</em></p>
                        </div>
                    </div>
                    <div class="step">
                        <span class="step-number">3</span>
                        <div class="step-content">
                            <strong>Confirmation</strong>
                            <p>Votre compte sera crédité sous 48h ouvrées après réception et encaissement du chèque.</p>
                        </div>
                    </div>
                </div>

                <a href="{{ url()->previous() }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Retour aux options de paiement
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de l'affichage du champ "autre banque"
            const banqueSelect = document.getElementById('banque-select');
            const autreBanqueContainer = document.getElementById('autre-banque-container');

            banqueSelect.addEventListener('change', function() {
                if (this.value === 'OTHER') {
                    autreBanqueContainer.style.display = 'block';
                    document.getElementById('autre-banque').required = true;
                } else {
                    autreBanqueContainer.style.display = 'none';
                    document.getElementById('autre-banque').required = false;
                }
            });

            // Validation du formulaire
            const form = document.getElementById('cheque-form');
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validation simple pour l'exemple
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });

            // Animation des champs lorsqu'ils reçoivent le focus
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.01)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });




        document.addEventListener('DOMContentLoaded', function() {
            const natureSelect = document.getElementById('NaturePaiement');
            const numeroLabel = document.querySelector('label[for="numero_cheque"]');
            const numeroInput = document.getElementById('numero_cheque');
            const formNote = document.querySelector('.form-note');

            natureSelect.addEventListener('change', function() {
                if (this.value === 'CHEQUE') {
                    numeroLabel.textContent = 'Numéro du chèque';
                    numeroInput.placeholder = 'CHQ-2023-001';
                    formNote.textContent = 'Ex: CHQ-2023-001 ou 2023/CHQ/001';
                    numeroInput.pattern = "[A-Za-z0-9-]+";
                    numeroInput.title = "Caractères alphanumériques et tirets uniquement";
                } else if (this.value === 'VIREMENT') {
                    numeroLabel.textContent = 'Numéro de virement';
                    numeroInput.placeholder = 'VIR-2023-001';
                    formNote.textContent = 'Ex: VIR-2023-001 ou REF/VIREMENT/2023';
                    numeroInput.pattern = "[A-Za-z0-9-/]+";
                    numeroInput.title = "Caractères alphanumériques, tirets et slashs uniquement";
                } else {
                    numeroLabel.textContent = 'Numéro';
                    numeroInput.placeholder = '';
                    formNote.textContent = '';
                }
            });

            // Déclencher l'événement au chargement si une valeur est déjà sélectionnée
            if (natureSelect.value) {
                natureSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>

</html>
