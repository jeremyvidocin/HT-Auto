<?php include('./views/layout/header.php'); ?>
<link rel="stylesheet" href="views/admin/admin.css">

<div class="admin-container">
    <div class="admin-sidebar">
        <h3>Administration</h3>
        <nav>
            <a href="index.php?action=admin">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
            <a href="index.php?action=admin&page=users">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="index.php?action=admin&page=cars" class="active">
                <i class="fas fa-car"></i> Véhicules
            </a>
            <a href="index.php?action=admin&page=bookings">
                <i class="fas fa-calendar-alt"></i> Réservations
            </a>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>Ajouter un véhicule</h1>
            <button class="btn-secondary" onclick="location.href='index.php?action=admin&page=cars'">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </button>
        </div>

        <div class="admin-card">
            <form action="index.php?action=admin&operation=addCar" method="POST" enctype="multipart/form-data" class="form-grid">
                <div class="form-group">
                    <label for="brand">Marque*</label>
                    <input type="text" id="brand" name="brand" required>
                </div>

                <div class="form-group">
                    <label for="model">Modèle*</label>
                    <input type="text" id="model" name="model" required>
                </div>

                <div class="form-group">
                    <label for="year">Année*</label>
                    <input type="number" id="year" name="year" min="1900" max="<?php echo date('Y') + 1; ?>" required>
                </div>

                <div class="form-group">
                    <label for="price">Prix (€)*</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="mileage">Kilométrage (km)*</label>
                    <input type="number" id="mileage" name="mileage" min="0" required>
                </div>

                <div class="form-group">
                    <label for="fuel_type">Type de carburant*</label>
                    <select id="fuel_type" name="fuel_type" required>
                        <option value="">Sélectionnez...</option>
                        <option value="Essence">Essence</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Électrique">Électrique</option>
                        <option value="Hybride">Hybride</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="transmission">Transmission*</label>
                    <select id="transmission" name="transmission" required>
                        <option value="">Sélectionnez...</option>
                        <option value="Manuelle">Manuelle</option>
                        <option value="Automatique">Automatique</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="power">Puissance (ch)*</label>
                    <input type="number" id="power" name="power" min="0" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image*</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <small>Format recommandé : JPG, PNG. Taille max : 5MB</small>
                </div>

                <div class="form-group full-width">
                    <label for="additional_images">Images supplémentaires</label>
                    <input type="file" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                    <small>Vous pouvez sélectionner plusieurs images</small>
                </div>

                <div class="form-actions full-width">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Enregistrer le véhicule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    padding: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    font-weight: 600;
    color: #333;
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group select,
.form-group textarea {
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-group textarea {
    resize: vertical;
}

.form-actions {
    margin-top: 1rem;
    display: flex;
    justify-content: flex-end;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-secondary:hover {
    background: #5a6268;
}

small {
    color: #666;
    font-size: 0.85rem;
}
</style>

<?php include('./views/layout/footer.php'); ?> 