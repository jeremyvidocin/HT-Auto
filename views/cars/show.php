
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
    </div>
</div>
</body>
<?php include('./views/layout/footer.php'); ?>
</html>