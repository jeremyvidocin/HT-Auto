<!-- views/layout/header.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Auto</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-gray: #f5f6fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: var(--light-gray);
        }

        .header {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
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
        }

        .nav-links a {
            color: var(--primary-color);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--accent-color);
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
        }

        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .car-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .car-card:hover {
            transform: translateY(-5px);
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
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
            gap: 0.5rem;
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
            color: var(--accent-color);
            margin: 1rem 0;
        }

        .btn-details {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .btn-details:hover {
            background-color: #34495e;
        }

        /* Style pour la page de détail */
        .car-detail {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .car-detail-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .car-specs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .spec-item {
            background: var(--light-gray);
            padding: 1rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="index.php" class="logo">Premium Auto</a>
            <div class="nav-links">
                <a href="index.php">Accueil</a>
                <a href="index.php?action=cars">Nos Véhicules</a>
                <a href="#">Contact</a>
            </div>
        </nav>
    </header>