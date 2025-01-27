<!-- views/cars/index.php -->
<div class="container">
    <h1 class="page-title">Nos Véhicules Premium</h1>
    <div class="car-grid">
        <?php while($row = $cars->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="car-card">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['brand'] . ' ' . $row['model']); ?>" class="car-image">
                <div class="car-content">
                    <h2 class="car-title"><?php echo htmlspecialchars($row['brand'] . ' ' . $row['model']); ?></h2>
                    <div class="car-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <?php echo htmlspecialchars($row['year']); ?>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-road"></i>
                            <?php echo number_format($row['mileage'], 0, ',', ' '); ?> km
                        </div>
                        <div class="info-item">
                            <i class="fas fa-gas-pump"></i>
                            <?php echo htmlspecialchars($row['fuel_type']); ?>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-cog"></i>
                            <?php echo htmlspecialchars($row['transmission']); ?>
                        </div>
                    </div>
                    <div class="car-price"><?php echo number_format($row['price'], 0, ',', ' '); ?> €</div>
                    <a href="index.php?action=show&id=<?php echo $row['id']; ?>" class="btn-details">Voir le détail</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>