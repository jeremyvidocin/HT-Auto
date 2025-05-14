<?php include('./views/layout/header.php'); ?>
<!-- views/cars/show.php -->
<div class="container">
    <div class="car-detail">
        <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>" class="car-detail-image">
        
        <h1 class="page-title"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h1>
        
        <div class="car-price">
            <?php echo number_format($car['price'], 0, ',', ' '); ?> €
        </div>

        <div class="car-specs">
            <div class="spec-item">
                <i class="fas fa-calendar"></i>
                <h3>Année</h3>
                <p><?php echo htmlspecialchars($car['year']); ?></p>
            </div>
            <div class="spec-item">
                <i class="fas fa-road"></i>
                <h3>Kilométrage</h3>
                <p><?php echo number_format($car['mileage'], 0, ',', ' '); ?> km</p>
            </div>
            <div class="spec-item">
                <i class="fas fa-gas-pump"></i>
                <h3>Carburant</h3>
                <p><?php echo htmlspecialchars($car['fuel_type']); ?></p>
            </div>
            <div class="spec-item">
                <i class="fas fa-cog"></i>
                <h3>Transmission</h3>
                <p><?php echo htmlspecialchars($car['transmission']); ?></p>
            </div>
            <div class="spec-item">
                <i class="fas fa-horse"></i>
                <h3>Puissance</h3>
                <p><?php echo htmlspecialchars($car['power']); ?> ch</p>
            </div>
        </div>

        <div class="car-description">
            <h2>Description</h2>
            <p><?php echo nl2br(htmlspecialchars($car['description'])); ?></p>
        </div>

        <div class="car-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?action=test_drive&car_id=<?php echo $car['id']; ?>" class="btn-action btn-test-drive">
                    <i class="fas fa-car"></i> Réserver un essai
                </a>
                <a href="index.php?action=devis&car_id=<?php echo $car['id']; ?>" class="btn-action btn-devis">
                    <i class="fas fa-file-invoice-dollar"></i> Obtenir un devis
                </a>
            <?php else: ?>
                <div class="login-prompt">
                    <p>Pour accéder à toutes les fonctionnalités :</p>
                    <a href="index.php?action=login&redirect=test_drive&car_id=<?php echo $car['id']; ?>" class="btn-action btn-login">
                        <i class="fas fa-sign-in-alt"></i> Connectez-vous
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <style>
        .car-actions {
            margin-top: 2rem;
            text-align: center;
        }

        .btn-action {
            display: inline-block;
            padding: 1rem 2rem;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 0 10px;
        }

        .btn-test-drive {
            background: var(--gradient-primary);
            box-shadow: var(--shadow-primary);
        }

        .btn-devis {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-login {
            background: linear-gradient(45deg, #3498db, #2980b9);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-secondary);
            color: white;
            text-decoration: none;
        }

        .login-prompt {
            background: rgba(0, 0, 0, 0.05);
            padding: 2rem;
            border-radius: 10px;
            margin-top: 2rem;
        }

        .login-prompt p {
            margin-bottom: 1rem;
            font-size: 1.1em;
            color: #666;
        }
        </style>
    </div>
</div>
<?php include('./views/layout/footer.php'); ?>
</html>