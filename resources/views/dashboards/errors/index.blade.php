<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - {{ $code ??404 }}</title>
    <style>
        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #343a40;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }

        /* Conteneur principal */
        .error-container {
            max-width: 600px;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Styles du code d'erreur */
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 20px;
            line-height: 1;
        }

        /* Titre */
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #212529;
        }

        /* Message */
        p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #6c757d;
        }

        /* Bouton */
        .home-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .home-button:hover {
            background-color: #0056b3;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .error-code {
                font-size: 80px;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">{{ $code ?? "404" }}</div>
        <h1>Oups ! Page non trouvée</h1>
        <p>{{ $mess ?? "Désolé, la page que vous recherchez n'existe pas ou a été déplacée. Vous pouvez retourner à la page d'accueil
            en cliquant sur le bouton ci-dessous." }}</p>
        <a href="{{ route('acceuil') }}" class="home-button">Retour à l'accueil</a>
    </div>
</body>

</html>
