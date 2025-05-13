<?php include('./views/layout/header.php'); ?>
<!-- views/cars/index.php -->
<div class="container">
    <h1 class="page-title">Nos Véhicules Premium</h1>
    <!-- views/cars/index.php - Ajoutez ceci avant la car-grid -->
<div class="filter-section">
    <form action="index.php" method="GET" class="filter-form">
        <input type="hidden" name="action" value="cars">
        <div class="filter-group">
            <label for="brand">Marque</label>
            <select name="brand" id="brand">
                <option value="">Toutes les marques</option>
                <?php foreach($filterOptions['brands'] as $brand): ?>
                    <option value="<?= htmlspecialchars($brand) ?>" 
                            <?= (isset($_GET['brand']) && $_GET['brand'] === $brand) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($brand) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label>Prix</label>
            <div class="range-inputs">
                <input type="number" name="price_min" placeholder="Min" 
                       value="<?= htmlspecialchars($_GET['price_min'] ?? '') ?>"
                       min="<?= $filterOptions['price_range']['min'] ?>" 
                       max="<?= $filterOptions['price_range']['max'] ?>">
                <input type="number" name="price_max" placeholder="Max" 
                       value="<?= htmlspecialchars($_GET['price_max'] ?? '') ?>"
                       min="<?= $filterOptions['price_range']['min'] ?>" 
                       max="<?= $filterOptions['price_range']['max'] ?>">
            </div>
        </div>

        <div class="filter-group">
            <label>Année</label>
            <div class="range-inputs">
                <input type="number" name="year_min" placeholder="Min" 
                       value="<?= htmlspecialchars($_GET['year_min'] ?? '') ?>"
                       min="<?= $filterOptions['year_range']['min'] ?>" 
                       max="<?= $filterOptions['year_range']['max'] ?>">
                <input type="number" name="year_max" placeholder="Max" 
                       value="<?= htmlspecialchars($_GET['year_max'] ?? '') ?>"
                       min="<?= $filterOptions['year_range']['min'] ?>" 
                       max="<?= $filterOptions['year_range']['max'] ?>">
            </div>
        </div>

        <div class="filter-group">
            <label for="fuel_type">Carburant</label>
            <select name="fuel_type" id="fuel_type">
                <option value="">Tous les carburants</option>
                <?php foreach($filterOptions['fuel_types'] as $fuel): ?>
                    <option value="<?= htmlspecialchars($fuel) ?>"
                            <?= (isset($_GET['fuel_type']) && $_GET['fuel_type'] === $fuel) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($fuel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label for="transmission">Transmission</label>
            <select name="transmission" id="transmission">
                <option value="">Toutes les transmissions</option>
                <?php foreach($filterOptions['transmissions'] as $transmission): ?>
                    <option value="<?= htmlspecialchars($transmission) ?>"
                            <?= (isset($_GET['transmission']) && $_GET['transmission'] === $transmission) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($transmission) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label for="sort">Trier par</label>
            <select name="sort" id="sort">
                <option value="">Par défaut</option>
                <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_asc') ? 'selected' : '' ?>>
                    Prix croissant
                </option>
                <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_desc') ? 'selected' : '' ?>>
                    Prix décroissant
                </option>
                <option value="year_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'year_desc') ? 'selected' : '' ?>>
                    Plus récent
                </option>
                <option value="mileage_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'mileage_asc') ? 'selected' : '' ?>>
                    Kilométrage croissant
                </option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="index.php?action=cars" class="btn-reset">Réinitialiser</a>
        </div>
    </form>
</div>

<style>
    .filter-section {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-weight: 500;
        color: var(--primary-color);
    }

    .filter-group select,
    .filter-group input {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .range-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
    }

    .btn-filter,
    .btn-reset {
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
    }

    .btn-filter {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-reset {
        background-color: #e0e0e0;
        color: var(--primary-color);
    }

    .btn-filter:hover {
        background-color: #34495e;
    }

    .btn-reset:hover {
        background-color: #d0d0d0;
    }
</style>
    <div class="car-grid">
        <?php while($row = $cars->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="car-card">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['brand'] . ' ' . $row['model']); ?>" class="car-image">
                <div class="car-content">
                    <h2 class="car-title"><?php echo htmlspecialchars($row['brand'] . ' ' . $row['model']); ?></h2>
                    <br>
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

<?php include('./views/layout/footer.php'); ?>