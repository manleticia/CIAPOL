<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .reset-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .reset-header {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0 !important;
        }

        .reset-body {
            padding: 2rem;
            background-color: white;
            border-radius: 0 0 15px 15px;
        }

        .form-label {
            font-weight: 600;
        }

        .required-field::after {
            content: " *";
            color: #e74a3b;
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .password-criteria {
            list-style-type: none;
            padding-left: 0;
        }

        .password-criteria li {
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 1.5rem;
        }

        .password-criteria li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #6c757d;
        }

        .criteria-valid {
            color: #28a745;
        }

        .criteria-invalid {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container py-5">
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
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="reset-card">
                    <div class="reset-header text-center">
                        <h2><i class="fas fa-key me-2"></i>Réinitialisation du mot de passe</h2>
                    </div>
                    <div class="reset-body">
                        <form method="POST" action="{{ route('storUpdaAccesAdmin',$administrateur->id) }}" id="resetForm">
                            @csrf
                            @method('POST')
                            <div class="mb-4">
                                <label for="email" class="form-label required-field">Adresse email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ $administrateur->email ?? old('email') }}" required readonly disabled>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 position-relative">
                                <label for="password" class="form-label required-field">Nouveau mot de passe</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 position-relative">
                                <label for="password-confirm" class="form-label required-field">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="password-confirm"
                                       name="password_confirmation" required>
                                <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"></i>
                            </div>

                            <div class="mb-4">
                                <h6 class="mb-2">Critères du mot de passe:</h6>
                                <ul class="password-criteria">
                                    <li id="criteria-length"><i class="fas fa-check-circle criteria-valid d-none"></i>
                                        <i class="fas fa-times-circle criteria-invalid"></i> Minimum 8 caractères</li>
                                    <li id="criteria-uppercase"><i class="fas fa-check-circle criteria-valid d-none"></i>
                                        <i class="fas fa-times-circle criteria-invalid"></i> Au moins une majuscule</li>
                                    <li id="criteria-lowercase"><i class="fas fa-check-circle criteria-valid d-none"></i>
                                        <i class="fas fa-times-circle criteria-invalid"></i> Au moins une minuscule</li>
                                    <li id="criteria-number"><i class="fas fa-check-circle criteria-valid d-none"></i>
                                        <i class="fas fa-times-circle criteria-invalid"></i> Au moins un chiffre</li>
                                    <li id="criteria-special"><i class="fas fa-check-circle criteria-valid d-none"></i>
                                        <i class="fas fa-times-circle criteria-invalid"></i> Au moins un caractère spécial</li>
                                </ul>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sync-alt me-2"></i>Réinitialiser le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordInput = document.getElementById('password-confirm');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Password validation
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;

            // Check length
            toggleCriteriaIcon('criteria-length', password.length >= 8);

            // Check uppercase
            toggleCriteriaIcon('criteria-uppercase', /[A-Z]/.test(password));

            // Check lowercase
            toggleCriteriaIcon('criteria-lowercase', /[a-z]/.test(password));

            // Check number
            toggleCriteriaIcon('criteria-number', /[0-9]/.test(password));

            // Check special character
            toggleCriteriaIcon('criteria-special', /[^A-Za-z0-9]/.test(password));
        });

        function toggleCriteriaIcon(id, isValid) {
            const criteria = document.getElementById(id);
            const validIcon = criteria.querySelector('.fa-check-circle');
            const invalidIcon = criteria.querySelector('.fa-times-circle');

            if (isValid) {
                validIcon.classList.remove('d-none');
                invalidIcon.classList.add('d-none');
                criteria.style.color = '#28a745';
            } else {
                validIcon.classList.add('d-none');
                invalidIcon.classList.remove('d-none');
                criteria.style.color = '#dc3545';
            }
        }

        // Form validation
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
                return false;
            }

            // Check all criteria are met
            const allValid = Array.from(document.querySelectorAll('.fa-check-circle')).every(
                icon => !icon.classList.contains('d-none')
            );

            if (!allValid) {
                e.preventDefault();
                alert('Veuillez respecter tous les critères du mot de passe.');
                return false;
            }

            return true;
        });
    </script>
</body>

</html>
