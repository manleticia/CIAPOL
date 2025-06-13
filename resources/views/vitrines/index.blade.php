<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Accueil</title>
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #003153;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            z-index: 10;
        }

        h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            text-align: center;
            background: linear-gradient(to right, #003153, #0066b1);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: fadeIn 1.5s ease-out, float 6s ease-in-out infinite;
            text-shadow: 0 0 20px rgba(0, 49, 83, 0.1);
            font-weight: 700;
        }

        p {
            font-size: 1.2rem;
            max-width: 600px;
            text-align: center;
            margin-bottom: 3rem;
            opacity: 0;
            animation: fadeIn 1s ease-out 0.5s forwards;
            color: #4a4a4a;
            line-height: 1.6;
        }

        .btn-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            opacity: 0;
            animation: fadeIn 1s ease-out 1s forwards;
        }

        .btn {
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            border: none;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #003153, #0066b1);
            color: white;
            box-shadow: 0 4px 20px rgba(0, 49, 83, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: #003153;
            border: 2px solid #003153;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 49, 83, 0.15);
        }

        .btn-primary:hover {
            box-shadow: 0 12px 24px rgba(0, 49, 83, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(0, 49, 83, 0.05);
            border-color: #0066b1;
            color: #0066b1;
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .btn:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0066b1, #003153);
            z-index: -1;
            transition: opacity 0.4s ease;
            opacity: 0;
        }

        .btn:hover:after {
            opacity: 1;
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

        /* Particules animées */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(0, 49, 83, 0.15);
            border-radius: 50%;
            animation: floatParticle linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        /* Effets géométriques animés */
        .geometric-shape {
            position: absolute;
            opacity: 0.08;
            z-index: 0;
            animation: rotate infinite linear;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            background: #003153;
            top: 10%;
            right: 5%;
            animation-duration: 25s;
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            background: #0066b1;
            bottom: 5%;
            left: 5%;
            animation-duration: 30s;
            animation-direction: reverse;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Effet de vague animée */
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="%23003153" opacity=".05"/><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="%23003153" opacity=".1"/><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23003153" opacity=".15"/></svg>');
            background-size: cover;
            background-repeat: no-repeat;
            z-index: 1;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            p {
                font-size: 1rem;
                padding: 0 20px;
            }

            .btn-container {
                flex-direction: column;
                width: 80%;
            }

            .shape-1,
            .shape-2 {
                width: 200px;
                height: 200px;
            }
        }
    </style>


    <style>
        .animate__animated {
            animation-duration: 0.5s;
        }

        .animate__shakeX {
            animation-name: shakeX;
        }

        @keyframes shakeX {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
        }
    </style>
</head>

<body>
    <div class="particles" id="particles"></div>
    <div class="geometric-shape shape-1"></div>
    <div class="geometric-shape shape-2"></div>
    <div class="wave"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Message d'erreur -->
                @if (session('error'))
                    <div class="alert alert-danger d-flex align-items-center mb-4 py-2">
                        <span class="badge bg-white text-danger me-3">ERREUR</span>
                        <div>
                            <h6 class="mb-0 text-danger">{{ session('error') }}</h6>
                        </div>
                    </div>
                @endif

                <!-- Le reste de votre contenu -->
            </div>
        </div>
        <h1>Bienvenue sur la plateforme de CIAPOL</h1>
        <p>incrivez pour payer vos fature de la periode de janvier 2020 à decembre 2024</p>

        <div class="btn-container">
            <button class="btn btn-primary" id="signup-btn">Inscription</button>
            @if (auth()->user())
                <a @if (auth()->user()->administrateur) href="{{ route('dashboard') }}" @else href="{{ route('espaceClient.index') }}" @endif
                    class="btn btn-secondary">Mon Espace</a>
            @else
                <button class="btn btn-secondary" id="login-btn">Connexion</button>
            @endif
        </div>
    </div>

    <script>
        // Création des particules animées
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 40;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Taille aléatoire entre 1px et 5px
                const size = Math.random() * 4 + 1;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Position initiale aléatoire
                particle.style.left = `${Math.random() * 100}vw`;
                particle.style.bottom = `-10px`;

                // Opacité aléatoire
                particle.style.opacity = Math.random() * 0.3 + 0.1;

                // Animation aléatoire
                const duration = Math.random() * 25 + 15;
                const delay = Math.random() * 10;
                particle.style.animation = `floatParticle ${duration}s linear ${delay}s infinite`;

                particlesContainer.appendChild(particle);
            }
        }

        // Effet de vague sur les boutons
        function addRippleEffect(button) {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;

                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.style.background = 'rgba(0, 49, 83, 0.3)';

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            createParticles();

            const signupBtn = document.getElementById('signup-btn');
            const loginBtn = document.getElementById('login-btn');

            addRippleEffect(signupBtn);
            addRippleEffect(loginBtn);

            // Exemple de fonctionnalité pour les boutons
            signupBtn.addEventListener('click', () => {

                window.location.href = '/inscriptioninstallation';
            });

            loginBtn.addEventListener('click', () => {

                window.location.href = '/connexion';
            });
        });
    </script>
</body>

</html>
