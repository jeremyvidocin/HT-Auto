<?php include('./views/layout/header.php'); ?>

<div class="container">
    <div class="booking-container">
        <div class="booking-sidebar">
            <div class="car-preview">
                <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>" class="car-preview-image">
                <div class="car-preview-overlay">
                    <h3><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
                </div>
            </div>
            
            <div class="car-details">
                <div class="car-price-tag">
                    <span class="price-label">Prix</span>
                    <span class="price-value"><?php echo number_format($car['price'], 0, ',', ' '); ?> €</span>
                </div>
                
                <div class="car-specs-mini">
                    <div class="spec-item-mini">
                        <i class="fas fa-calendar"></i>
                        <span><?php echo $car['year']; ?></span>
                    </div>
                    <div class="spec-item-mini">
                        <i class="fas fa-road"></i>
                        <span><?php echo number_format($car['mileage'], 0, ',', ' '); ?> km</span>
                    </div>
                    <div class="spec-item-mini">
                        <i class="fas fa-gas-pump"></i>
                        <span><?php echo htmlspecialchars($car['fuel_type']); ?></span>
                    </div>
                </div>
                
                <a href="index.php?action=show&id=<?php echo $car['id']; ?>" class="btn-link">
                    <i class="fas fa-arrow-left"></i> Retour à la fiche véhicule
                </a>
            </div>
            
            <div class="booking-info-sidebar">
                <h4><i class="fas fa-info-circle"></i> Informations importantes</h4>
                <ul>
                    <li>Permis de conduire obligatoire le jour de l'essai</li>
                    <li>Essai d'une durée de 30 minutes</li>
                    <li>Un conseiller vous accompagnera</li>
                    <li>Réservation gratuite et sans engagement</li>
                </ul>
            </div>
        </div>
        
        <div class="booking-form-container">
            <h1 class="booking-title"><i class="fas fa-calendar-check"></i> Réserver un essai</h1>
            
            <?php if (isset($_SESSION['booking_errors']) && !empty($_SESSION['booking_errors'])): ?>
                <div class="booking-alert booking-alert-error">
                    <?php foreach($_SESSION['booking_errors'] as $error): ?>
                        <p><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['booking_errors']); ?>
                </div>
            <?php endif; ?>
            
            <p class="booking-intro">
                Réservez votre essai de la <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?> en 
                sélectionnant une date et une heure qui vous conviennent.
            </p>

            <form action="index.php?action=process_test_drive" method="POST" class="booking-form">
                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="booking_date">Date souhaitée</label>
                        <div class="input-with-icon">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" id="booking_date" name="booking_date" required 
                                min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                                max="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="booking_time">Heure souhaitée</label>
                        <div class="input-with-icon">
                            <i class="fas fa-clock"></i>
                            <select id="booking_time" name="booking_time" required>
                                <option value="">Choisissez une heure</option>
                                <option value="09:00:00">09:00</option>
                                <option value="10:00:00">10:00</option>
                                <option value="11:00:00">11:00</option>
                                <option value="14:00:00">14:00</option>
                                <option value="15:00:00">15:00</option>
                                <option value="16:00:00">16:00</option>
                                <option value="17:00:00">17:00</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes">Questions ou remarques</label>
                    <div class="input-with-icon">
                        <i class="fas fa-comment"></i>
                        <textarea id="notes" name="notes" rows="3" placeholder="Informations supplémentaires..."></textarea>
                    </div>
                </div>
                
                <div class="time-slots-info">
                    <h3><i class="fas fa-clock"></i> Informations sur les créneaux</h3>
                    <p>Les essais sont disponibles du lundi au samedi.</p>
                    <div class="time-slots-grid">
                        <div class="time-slot">
                            <span class="time-range">Matin</span>
                            <span class="time-values">9h00 - 12h00</span>
                        </div>
                        <div class="time-slot">
                            <span class="time-range">Après-midi</span>
                            <span class="time-values">14h00 - 18h00</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="index.php?action=show&id=<?php echo $car['id']; ?>" class="btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-check"></i> Confirmer la réservation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.booking-container {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 2rem;
    margin: 2rem 0;
}

.booking-sidebar {
    position: sticky;
    top: 6rem;
    height: fit-content;
}

.car-preview {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.car-preview-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.car-preview:hover .car-preview-image {
    transform: scale(1.05);
}

.car-preview-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
}

.car-details {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.car-price-tag {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.price-label {
    font-size: 0.9rem;
    color: #666;
}

.price-value {
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--primary-color);
}

.car-specs-mini {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.spec-item-mini {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.spec-item-mini i {
    font-size: 1.2rem;
    color: var(--primary-color);
}

.btn-link {
    display: block;
    text-align: center;
    color: var(--primary-color);
    text-decoration: none;
    padding: 0.8rem;
    border: 1px solid var(--primary-color);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-link i {
    margin-right: 0.5rem;
}

.btn-link:hover {
    background: var(--primary-color);
    color: white;
}

.booking-info-sidebar {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.booking-info-sidebar h4 {
    color: var(--primary-color);
    margin-top: 0;
    margin-bottom: 1rem;
}

.booking-info-sidebar i {
    margin-right: 0.5rem;
}

.booking-info-sidebar ul {
    padding-left: 1rem;
}

.booking-info-sidebar li {
    margin-bottom: 0.8rem;
}

.booking-form-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.booking-title {
    color: var(--primary-color);
    margin-top: 0;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f5f5f5;
}

.booking-title i {
    margin-right: 0.5rem;
}

.booking-alert {
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.booking-alert-error {
    background-color: #fee2e2;
    color: #b91c1c;
    border-left: 4px solid #dc2626;
}

.booking-alert p {
    margin: 0.5rem 0;
}

.booking-alert i {
    margin-right: 0.5rem;
}

.booking-intro {
    color: #666;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark-color);
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    z-index: 1;
}

.input-with-icon input,
.input-with-icon select,
.input-with-icon textarea {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #eee;
    border-radius: 10px;
    font-size: 1rem;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

.input-with-icon textarea {
    padding-top: 1.2rem;
}

.input-with-icon textarea ~ i {
    top: 1.2rem;
}

.input-with-icon input:focus,
.input-with-icon select:focus,
.input-with-icon textarea:focus {
    border-color: var(--primary-color);
    background-color: white;
    box-shadow: 0 0 0 3px rgba(255,107,107,0.25);
    outline: none;
}

.time-slots-info {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.time-slots-info h3 {
    color: var(--primary-color);
    margin-top: 0;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.time-slots-info h3 i {
    margin-right: 0.5rem;
}

.time-slots-info p {
    margin-bottom: 1rem;
}

.time-slots-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.time-slot {
    background-color: white;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.time-range {
    display: block;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    gap: 1rem;
}

.btn-secondary {
    padding: 1rem 2rem;
    background: #e0e0e0;
    color: var(--dark-color);
    text-decoration: none;
    border-radius: 10px;
    border: none;
    font-size: 1rem;
    cursor: pointer;
    flex-grow: 1;
    text-align: center;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #d0d0d0;
}

.btn-primary {
    padding: 1rem 2rem;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    flex-grow: 2;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 14px rgba(255,107,107,0.25);
}

.btn-primary i, .btn-secondary i {
    margin-right: 0.5rem;
}

@media (max-width: 992px) {
    .booking-container {
        grid-template-columns: 1fr;
    }
    
    .booking-sidebar {
        position: static;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .booking-info-sidebar {
        grid-column: span 2;
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .booking-sidebar {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<?php include('./views/layout/footer.php'); ?>