<?php include('./views/layout/header.php'); ?>

<div class="container">
    <h1 class="page-title">Mes Réservations d'Essai</h1>
    
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success">
            Votre réservation a été enregistrée avec succès ! Nous vous contacterons pour confirmer votre essai.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['cancelled']) && $_GET['cancelled'] == 1): ?>
        <div class="alert alert-success">
            Votre réservation a été annulée avec succès.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-error">
            Une erreur est survenue lors du traitement de votre demande.
        </div>
    <?php endif; ?>

    <?php if ($bookings->rowCount() > 0): ?>
        <div class="bookings-list">
            <?php while($booking = $bookings->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="booking-card">
                    <div class="booking-image">
                        <img src="<?php echo htmlspecialchars($booking['image']); ?>" alt="<?php echo htmlspecialchars($booking['brand'] . ' ' . $booking['model']); ?>">
                    </div>
                    
                    <div class="booking-details">
                        <h3><?php echo htmlspecialchars($booking['brand'] . ' ' . $booking['model']); ?></h3>
                        
                        <div class="booking-info">
                            <p>
                                <i class="fas fa-calendar"></i>
                                <strong>Date:</strong> 
                                <?php echo date('d/m/Y', strtotime($booking['booking_date'])); ?>
                            </p>
                            <p>
                                <i class="fas fa-clock"></i>
                                <strong>Heure:</strong> 
                                <?php echo date('H:i', strtotime($booking['booking_time'])); ?>
                            </p>
                            <p>
                                <i class="fas fa-tag"></i>
                                <strong>Statut:</strong> 
                                <span class="status status-<?php echo strtolower($booking['status']); ?>">
                                    <?php
                                    switch($booking['status']) {
                                        case 'pending': echo 'En attente'; break;
                                        case 'confirmed': echo 'Confirmé'; break;
                                        case 'completed': echo 'Terminé'; break;
                                        case 'cancelled': echo 'Annulé'; break;
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                        
                        <?php if (!empty($booking['notes'])): ?>
                            <div class="booking-notes">
                                <p><strong>Remarques:</strong> <?php echo nl2br(htmlspecialchars($booking['notes'])); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($booking['status'] == 'pending'): ?>
                            <div class="booking-actions">
                                <a href="index.php?action=cancel_booking&id=<?php echo $booking['id']; ?>" class="btn-cancel" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                    Annuler la réservation
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-bookings">
            <p>Vous n'avez pas encore de réservations d'essai.</p>
            <p><a href="index.php?action=cars" class="btn-primary">Découvrir nos véhicules</a></p>
        </div>
    <?php endif; ?>
</div>

<style>
.bookings-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin: 2rem 0;
}

.booking-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    display: flex;
}

.booking-image {
    width: 200px;
}

.booking-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.booking-details {
    padding: 1.5rem;
    flex-grow: 1;
}

.booking-details h3 {
    color: var(--primary-color);
    margin: 0 0 1rem 0;
}

.booking-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.booking-info p {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.status {
    font-weight: bold;
    padding: 0.25rem 0.5rem;
    border-radius: 3px;
}

.status-pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status-confirmed {
    background-color: #dcfce7;
    color: #166534;
}

.status-completed {
    background-color: #dbeafe;
    color: #1e40af;
}

.status-cancelled {
    background-color: #fee2e2;
    color: #b91c1c;
}

.booking-notes {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px dashed #eee;
}

.booking-actions {
    margin-top: 1.5rem;
}

.btn-cancel {
    background-color: #f87171;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
}

.btn-cancel:hover {
    background-color: #ef4444;
}

.no-bookings {
    text-align: center;
    margin: 3rem 0;
}

@media (max-width: 768px) {
    .booking-card {
        flex-direction: column;
    }
    
    .booking-image {
        width: 100%;
        height: 200px;
    }
}
</style>

<?php include('./views/layout/footer.php'); ?>