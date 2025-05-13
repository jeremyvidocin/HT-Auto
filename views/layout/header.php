<!-- views/layout/header.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Auto</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/home.css">
    
    <!-- Inclure les styles pour les alertes -->
    <?php include('./views/layout/alerts.php'); ?>
    
    <style>
        :root {
    /* Palette de couleurs vibrantes et modernes */
    --primary-color: #FF6B6B;     /* Rose corail vibrant */
    --secondary-color: #FFD93D;   /* Orange jaune énergique */
    --accent-color: #6BCB77;      /* Vert frais */
    --dark-color: #4D4D4D;        /* Gris anthracite */
    --light-color: #F7FFF7;       /* Blanc légèrement teinté */
    --light-gray: #f5f5f5;        /* Gris clair pour fond */

    /* Dégradés dynamiques */
    --gradient-primary: linear-gradient(135deg, #FF6B6B 0%, #FFD93D 100%);
    --gradient-secondary: linear-gradient(135deg, #6BCB77 0%, #4ECDC4 100%);

    /* Ombres et effets */
    --shadow-primary: 0 10px 20px rgba(255,107,107,0.3);
    --shadow-secondary: 0 15px 30px rgba(255,217,61,0.3);
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: var(--light-gray);
            color: var(--dark-color);
        }

        .header {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            font-size: 1.8rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-links a {
            color: var(--primary-color);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-links a:hover {
            background-color: rgba(255,107,107,0.1);
            color: var(--primary-color);
        }

        .container {
            max-width: 1400px;
            margin: 6rem auto 2rem;
            padding: 0 20px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 1rem;
        }

        .page-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .car-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-image {
            transform: scale(1.05);
        }

        .car-content {
            padding: 1.5rem;
        }

        .car-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .car-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
        }

        .car-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .car-price::before {
            content: "€";
            font-size: 0.8rem;
            background: var(--primary-color);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-details {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: var(--gradient-primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            text-align: center;
            box-shadow: 0 5px 15px rgba(255,107,107,0.3);
            font-weight: 500;
        }

        .btn-details:hover {
            box-shadow: 0 7px 20px rgba(255,107,107,0.5);
            transform: translateY(-2px);
        }

        /* Style pour la page de détail */
        .car-detail {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .car-detail-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.5s ease;
        }

        .car-detail:hover .car-detail-image {
            transform: scale(1.02);
        }

        .car-specs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .spec-item {
            background: var(--light-gray);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .spec-item:hover {
            transform: translateY(-5px);
        }

        .spec-item i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .spec-item h3 {
            font-size: 1rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .spec-item p {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--dark-color);
        }

        .user-menu {
            position: relative;
            display: inline-block;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 50px;
            background-color: var(--light-gray);
            transition: all 0.3s ease;
        }

        .user-menu:hover {
            background-color: rgba(255,107,107,0.1);
        }

        .user-menu span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-menu i {
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .user-menu:hover .dropdown-menu {
            display: block;
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 10px;
            padding: 1rem 0;
            z-index: 1000;
        }

        .dropdown-menu:before {
            content: "";
            position: absolute;
            top: -10px;
            right: 20px;
            border-width: 0 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent white transparent;
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dropdown-menu a:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }

        .dropdown-menu a i {
            width: 20px;
            text-align: center;
        }

        .auth-links {
            display: flex;
            gap: 1rem;
        }

        .auth-links a {
            display: inline-block;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .auth-links a:first-child {
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .auth-links a:last-child {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-primary);
        }

        .auth-links a:first-child:hover {
            background-color: rgba(255,107,107,0.1);
        }

        .auth-links a:last-child:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-secondary);
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="index.php" class="logo">
                <i class="fas fa-car-side"></i>
                Premium Auto
            </a>
            <div class="nav-links">
                <a href="index.php"><i class="fas fa-home"></i> Accueil</a>
                <a href="index.php?action=cars"><i class="fas fa-car"></i> Nos Véhicules</a>
                <a href="index.php?action=contact"><i class="fas fa-envelope"></i> Contact</a>
                <div class="user-section">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-menu">
                            <span>
                                <i class="fas fa-user-circle"></i>
                                <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur'); ?>
                            </span>
                            <div class="dropdown-menu">
                                <a href="index.php?action=profile"><i class="fas fa-user"></i> Mon profil</a>
                                <a href="index.php?action=my_bookings"><i class="fas fa-calendar-check"></i> Mes réservations</a>
                                <a href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="auth-links">
                            <a href="index.php?action=login">Connexion</a>
                            <a href="index.php?action=register">Inscription</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Script pour l'effet d'ombre du header au scroll -->
    <script>
        window.addEventListener('scroll', function() {
            var header = document.querySelector('.header');
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>