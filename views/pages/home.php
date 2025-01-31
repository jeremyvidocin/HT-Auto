<?php include('./views/layout/header.php'); ?>

<div class="home-hero">
    <div class="hero-content">
        <h1>Premium Auto : Votre Partenaire Automobile de Confiance</h1>
        <p>Découvrez une sélection exceptionnelle de véhicules haut de gamme</p>
        <a href="index.php?action=cars" class="btn-primary">Voir nos véhicules</a>
    </div>
</div>

<section class="featured-cars container">
    <h2>Nos Véhicules en Vedette</h2>
    <div class="car-grid">
        <?php foreach($featuredCars as $car): ?>
            <div class="car-card">
                <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>" class="car-image">
                <div class="car-content">
                    <h3><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
                    <div class="car-details">
                        <span><?php echo $car['year']; ?></span>
                        <span><?php echo number_format($car['price'], 0, ',', ' '); ?> €</span>
                    </div>
                    <a href="index.php?action=show&id=<?php echo $car['id']; ?>" class="btn-details">Détails</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="home-stats container">
    <h2>Premium Auto en Chiffres</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-car"></i>
            <h3><?php echo $stats['total_cars']; ?></h3>
            <p>Véhicules en stock</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-calendar"></i>
            <h3><?php echo $stats['oldest_car']; ?></h3>
            <p>Année du véhicule le plus ancien</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-euro-sign"></i>
            <h3><?php echo number_format($stats['max_price'], 0, ',', ' '); ?> €</h3>
            <p>Prix du véhicule le plus cher</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-tags"></i>
            <h3><?php echo number_format($stats['avg_price'], 0, ',', ' '); ?> €</h3>
            <p>Prix moyen</p>
        </div>
    </div>
</section>

<section class="home-services container">
    <h2>Nos Services</h2>
    <div class="services-grid">
        <div class="service-card">
            <i class="fas fa-car-alt"></i>
            <h3>Reprise de votre véhicule</h3>
            <p>Nous estimons et reprenons votre ancien véhicule</p>
        </div>
        <div class="service-card">
            <i class="fas fa-hand-holding-usd"></i>
            <h3>Financement</h3>
            <p>Solutions de crédit personnalisées</p>
        </div>
        <div class="service-card">
            <i class="fas fa-tools"></i>
            <h3>Entretien</h3>
            <p>Atelier mécanique agréé toutes marques</p>
        </div>
        <div class="service-card">
            <i class="fas fa-car"></i>
            <h3>Essai</h3>
            <p>Réservez un essai de votre futur véhicule</p>
        </div>
    </div>
</section>

<section class="home-testimonial container">
    <h2>Nos Clients Témoignent</h2>
    <div class="testimonial-grid">
        <div class="testimonial-card">
            <p>"Un service impeccable et des véhicules de haute qualité. Je recommande !"</p>
            <div class="client-info">
                <img src="/public/images/client1.jpg" alt="Client 1">
                <span>Jean D.</span>
            </div>
        </div>
        <div class="testimonial-card">
            <p>"Professionnalisme et conseil. J'ai trouvé mon bonheur chez Premium Auto."</p>
            <div class="client-info">
                <img src="/public/images/client2.jpg" alt="Client 2">
                <span>Marie S.</span>
            </div>
        </div>
    </div>
</section>

<?php include('./views/layout/footer.php'); ?>

<style>
    /* Styles spécifiques à la page d'accueil */
    .home-hero {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                    url('/public/images/hero-background.jpg') no-repeat center center;
        background-size: cover;
        color: white;
        text-align: center;
        padding: 6rem 2rem;
    }

    .hero-content h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .home-stats, .home-services, .home-testimonial {
        padding: 4rem 0;
        text-align: center;
    }

    .stats-grid, .services-grid, .testimonial-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .stat-card, .service-card, .testimonial-card {
        background: var(--light-gray);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .stat-card i, .service-card i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .testimonial-card img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>