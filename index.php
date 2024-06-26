<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/12471feb02.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Accueil - CAPTECH</title>
    <style>
        .hero {
            background-color: #f8f9fa;
            padding: 60px 0;
            text-align: center;
            animation: fadeIn 2s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .feature-icon {
            font-size: 3rem;
            color: #007bff;
            transition: transform 0.3s;
        }
        .feature-icon:hover {
            transform: scale(1.1);
        }
        .testimonial {
            background-color: #f1f1f1;
            padding: 40px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: slideInUp 1s;
        }
        @keyframes slideInUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 40px 0;
        }
        .footer h5 {
            font-size: 16px;
            margin-bottom: 20px;
            color: #343a40;
            text-transform: uppercase;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer a:hover {
            color: #0056b3;
        }
        .footer .social-icons a {
            color: #007bff;
            margin: 0 10px;
            font-size: 1.5rem;
            transition: color 0.3s;
        }
        .footer .social-icons a:hover {
            color: #0056b3;
        }
        .footer .social-icons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .footer .footer-bottom {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span>CAPTECH</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link btn btn-primary text-black" href="login.php">Se connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero bg-light py-5">
        <div class="container text-center">
            <h1>Bienvenue sur CAPTECH</h1>
            <p>Gérez vos projets efficacement et collaborez avec votre équipe en toute simplicité.</p>
            <a href="login.php" class="btn btn-primary">Commencer</a>
        </div>
    </div>

   <!-- Features Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Nos Fonctionnalités</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-tasks feature-icon mb-3"></i>
                    <h3>Gestion de Projet</h3>
                    <p>Suivez et gérez tous vos projets en un seul endroit avec des outils de planification et de suivi des tâches.</p>
                    <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-users feature-icon mb-3"></i>
                    <h3>Collaboration en Équipe</h3>
                    <p>Travaillez ensemble avec des outils de collaboration intégrés, des discussions en temps réel et le partage de fichiers.</p>
                    <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-chart-line feature-icon mb-3"></i>
                    <h3>Rapports et Analyses</h3>
                    <p>Obtenez des insights détaillés sur la progression de vos projets grâce à des rapports et des tableaux de bord intuitifs.</p>
                    <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonials Section -->
    <div class="container my-5">
        <h2 class="text-center">Ce que disent nos clients</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial bg-light p-4 rounded">
                    <p>"CAPTECH a transformé notre façon de gérer les projets. Une solution incontournable!"</p>
                    <p class="name fw-bold mt-3">- Bouba, CEO</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial bg-light p-4 rounded">
                    <p>"Une interface intuitive et des fonctionnalités puissantes. Je recommande fortement!"</p>
                    <p class="name fw-bold mt-3">- ousmane, Chef de Projet</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial bg-light p-4 rounded">
                    <p>"La meilleure solution pour la collaboration en équipe. Nous avons gagné en efficacité."</p>
                    <p class="name fw-bold mt-3">- teddy, Directeur Technique</p>
                </div>
            </div>
        </div>
    </div>

   <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>À propos de nous</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Notre histoire</a></li>
                        <li><a href="#">Équipe</a></li>
                        <li><a href="#">Carrières</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Support</a></li>
                        <li><a href="#">captech@gmail.com</a></li>
                        <li><a href="#">+33 000 00 00 00 </a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Suivez-nous</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center mt-4">
                <p>&copy; 2024 CAPTECH. Tous droits réservés.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>