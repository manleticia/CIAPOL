<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'inscription</title>
     <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .confirmation-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .confirmation-header {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .confirmation-body {
            padding: 3rem;
            background-color: white;
        }

        .check-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }

        .btn-outline-success {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }

        .details-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .detail-item {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="confirmation-card">
                    <div class="confirmation-header">
                        <h1><i class="fas fa-check-circle me-2"></i> Félicitations !</h1>
                    </div>
                    <div class="confirmation-body text-center">
                        <div class="check-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="text-success mb-3">Votre inscription a bien été enregistrée</h2>
                        <p class="lead mb-4">Nous avons bien reçu votre demande d'inscription.</p>

                        <div class="details-box text-start">
                            <h4 class="mb-3">Récapitulatif :</h4>
                            <div class="detail-item">
                                <strong><i class="fas fa-tag me-2 text-success"></i>Libellé :</strong>
                                <span id="libelle">{{ $inscrit->libelle ?? 'Nom de votre installation' }}</span>
                            </div>
                            <div class="detail-item">
                                <strong><i class="fas fa-envelope me-2 text-success"></i>Email :</strong>
                                <span id="email">{{ $inscrit->email ?? 'votre@email.com' }}</span>
                            </div>
                            <div class="detail-item">
                                <strong><i class="fas fa-phone me-2 text-success"></i>Téléphone :</strong>
                                <span id="telephone">{{ $inscrit->telephone ?? '01 02 03 04 05' }}</span>
                            </div>
                        </div>

                        <p class="mb-4">Un email de confirmation vous a été envoyé avec tous les détails. </p>

                        <div class="d-flex justify-content-center flex-wrap gap-3 mt-5">
                            <a href="{{route('acceuil')  }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i> Retour à l'accueil
                            </a>
                            {{-- <a href="/contact" class="btn btn-outline-success">
                                <i class="fas fa-envelope me-2"></i> Nous contacter
                            </a>
                            <a href="/mon-compte" class="btn btn-outline-primary">
                                <i class="fas fa-user me-2"></i> Accéder à mon compte
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-footer text-center py-3 bg-light">
                        <small class="text-muted">Merci pour votre confiance - © {{ date('Y') }}
                            CIAPOL</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation simple pour le check icon
        document.addEventListener('DOMContentLoaded', function() {
            const checkIcon = document.querySelector('.check-icon');
            checkIcon.style.transform = 'scale(0)';
            setTimeout(() => {
                checkIcon.style.transition = 'transform 0.5s ease-out';
                checkIcon.style.transform = 'scale(1)';
            }, 100);
        });
    </script>
</body>

</html>
