<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un accès utilisateur</title>
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .access-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .access-header {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0 !important;
        }

        .access-body {
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

        .role-badge {
            font-size: 0.9rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="access-card">
                    <div class="access-header text-center">
                        <h2><i class="fas fa-user-shield me-2"></i>Création d'un accès utilisateur</h2>
                    </div>
                    <div class="access-body">
                        <form method="POST" action="{{ route('traitAccesEntreprise') }}" id="accessForm">
                            @csrf
                            @method('POST')
                            <input type="text" name="entreprise_id"
                                value="{{ $entreprise->id ?? $inscrit->entreprise_id }}" hidden>

                            <input type="text" name="inscrit_id" value="{{ $inscrit->id }}" hidden>
                            <!-- Section Informations personnelles -->
                            <h5 class="mb-4 text-primary"><i class="fas fa-id-card me-2"></i>Informations personnelles
                            </h5>
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label for="first_name" class="form-label required-field">Raison Social</label>
                                    <input type="text" class="form-control" id="first_name"
                                        value="{{ old('first_name', $entreprise->raison_sociale) }}" readonly disabled>
                                    <input type="text" class="form-control" name="raison_sociale"
                                        value="{{ old('first_name', $entreprise->raison_sociale) }}" hidden>

                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label required-field">Email</label>
                                    <input type="email" class="form-control" id="email"
                                        value="{{ old('email', $inscrit->email) }}" readonly disabled>

                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $inscrit->email) }}" hidden>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="phone"
                                        value="{{ old('phone', $inscrit->telephone) }}"readonly disabled>
                                    <input type="tel" class="form-control" name="telephone"
                                        value="{{ old('phone', $inscrit->telephone) }}" hidden>
                                    {{-- @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror --}}
                                </div>
                            </div>

                            <!-- Section Identifiants -->
                            <h5 class="mb-4 text-primary"><i class="fas fa-key me-2"></i>Identifiants de connexion</h5>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 position-relative">
                                    <label for="password" class="form-label required-field">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3 position-relative">
                                    <label for="password_confirmation"
                                        class="form-label required-field">Confirmation</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                    <i class="fas fa-eye password-toggle" id="togglePasswordConfirmation"></i>
                                </div>
                                <div class="col-12">
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div id="passwordStrength" class="progress-bar" role="progressbar"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small id="passwordHelp" class="form-text text-muted">
                                        Le mot de passe doit contenir au moins 8 caractères, une majuscule, une
                                        minuscule, un chiffre et un caractère spécial.
                                    </small>
                                </div>
                            </div>

                            {{-- <!-- Section Rôles et Permissions -->
                            <h5 class="mb-4 text-primary"><i class="fas fa-user-tag me-2"></i>Rôles et Permissions</h5>
                            <div class="row mb-4">
                                <div class="col-12 mb-3">
                                    <label class="form-label required-field">Rôles</label>
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check me-4 mb-2">
                                            <input class="form-check-input" type="radio" name="role"
                                                id="role_admin" value="admin" checked>
                                            <label class="form-check-label" for="role_admin">
                                                <span class="badge bg-danger role-badge">Administrateur</span>
                                            </label>
                                        </div>
                                        <div class="form-check me-4 mb-2">
                                            <input class="form-check-input" type="radio" name="role"
                                                id="role_editor" value="editor">
                                            <label class="form-check-label" for="role_editor">
                                                <span class="badge bg-warning text-dark role-badge">Éditeur</span>
                                            </label>
                                        </div>
                                        <div class="form-check me-4 mb-2">
                                            <input class="form-check-input" type="radio" name="role"
                                                id="role_viewer" value="viewer">
                                            <label class="form-check-label" for="role_viewer">
                                                <span class="badge bg-info role-badge">Consultant</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('role')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Permissions supplémentaires</label>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="permission_export" name="permissions[]" value="export">
                                                <label class="form-check-label" for="permission_export">
                                                    Export de données
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="permission_manage_users" name="permissions[]"
                                                    value="manage_users">
                                                <label class="form-check-label" for="permission_manage_users">
                                                    Gestion utilisateurs
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="permission_advanced_settings" name="permissions[]"
                                                    value="advanced_settings">
                                                <label class="form-check-label" for="permission_advanced_settings">
                                                    Paramètres avancés
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Options -->
                            <h5 class="mb-4 text-primary"><i class="fas fa-cog me-2"></i>Options</h5>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="send_welcome_email"
                                            name="send_welcome_email" checked>
                                        <label class="form-check-label" for="send_welcome_email">
                                            Envoyer un email de bienvenue
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="force_password_change"
                                            name="force_password_change">
                                        <label class="form-check-label" for="force_password_change">
                                            Forcer le changement de mot de passe
                                        </label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="d-flex justify-content-between mt-5">
                                <a href="{{ route('acceuil') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Accueil
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Créer l'accès
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

        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordHelp');

            let strength = 0;

            // Check length
            if (password.length >= 8) strength += 20;
            if (password.length >= 12) strength += 20;

            // Check for different character types
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^A-Za-z0-9]/.test(password)) strength += 20;

            // Update UI
            strengthBar.style.width = strength + '%';
            strengthBar.setAttribute('aria-valuenow', strength);

            // Change color based on strength
            if (strength < 40) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.className = 'form-text text-danger';
            } else if (strength < 80) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.className = 'form-text text-warning';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.className = 'form-text text-success';
            }
        });
    </script>
</body>

</html>
