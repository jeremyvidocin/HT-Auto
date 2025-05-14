<?php include('./views/layout/header.php'); ?>
<link rel="stylesheet" href="views/admin/admin.css">

<?php
// Fonction de traduction des statuts
function translateStatus($status) {
    $translations = [
        'pending' => 'En attente',
        'confirmed' => 'Confirmé',
        'completed' => 'Terminé',
        'cancelled' => 'Annulé'
    ];
    return $translations[$status] ?? ucfirst($status);
}
?>

<div class="admin-container">
    <div class="admin-sidebar">
        <h3>Administration</h3>
        <nav>
            <a href="index.php?action=admin" class="active">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
            <a href="index.php?action=admin&page=users">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="index.php?action=admin&page=cars">
                <i class="fas fa-car"></i> Véhicules
            </a>
            <a href="index.php?action=admin&page=bookings">
                <i class="fas fa-calendar-alt"></i> Réservations
            </a>
        </nav>
    </div>

    <div class="admin-content">
        <h1>Tableau de bord</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo $stats['total_users']; ?></h3>
                <p>Utilisateurs inscrits</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-car"></i>
                <h3><?php echo $stats['total_cars']; ?></h3>
                <p>Véhicules en stock</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar-check"></i>
                <h3><?php echo $stats['total_bookings']; ?></h3>
                <p>Réservations totales</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <h3><?php echo $stats['pending_bookings']; ?></h3>
                <p>Réservations en attente</p>
            </div>
        </div>

        <div class="admin-grid">
            <div class="admin-card">
                <h2>Dernières réservations</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Véhicule</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentBookings as $booking): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['firstname'] . ' ' . $booking['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($booking['brand'] . ' ' . $booking['model']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($booking['booking_date'] . ' ' . $booking['booking_time'])); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $booking['status']; ?>">
                                        <?php echo translateStatus($booking['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="index.php?action=admin&page=bookings" class="btn-link">Voir toutes les réservations</a>
            </div>

            <div class="admin-card">
                <h2>Nouveaux utilisateurs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Date d'inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentUsers as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="index.php?action=admin&page=users" class="btn-link">Voir tous les utilisateurs</a>
            </div>
        </div>
    </div>
</div>

<?php include('./views/layout/footer.php'); ?> 