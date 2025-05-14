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
            <a href="index.php?action=admin&page=cars">
                <i class="fas fa-car"></i> Véhicules
            </a>
            <a href="index.php?action=admin&page=bookings" class="active">
                <i class="fas fa-calendar-alt"></i> Réservations
            </a>
        </nav>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>Gestion des réservations</h1>
            <div class="filter-status">
                <label for="status-filter">Filtrer par statut :</label>
                <select id="status-filter" class="status-select">
                    <option value="all">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="confirmed">Confirmé</option>
                    <option value="completed">Terminé</option>
                    <option value="cancelled">Annulé</option>
                </select>
            </div>
        </div>

        <div class="admin-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Véhicule</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Statut</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr data-booking-id="<?php echo $booking['id']; ?>">
                            <td><?php echo htmlspecialchars($booking['id']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($booking['firstname'] . ' ' . $booking['lastname']); ?><br>
                                <small><?php echo htmlspecialchars($booking['email']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($booking['brand'] . ' ' . $booking['model']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($booking['booking_date'])); ?></td>
                            <td><?php echo date('H:i', strtotime($booking['booking_time'])); ?></td>
                            <td class="status-cell"><?php echo htmlspecialchars($booking['status']); ?></td>
                            <td>
                                <div class="notes-cell">
                                    <?php echo htmlspecialchars($booking['notes'] ?: 'Aucune note'); ?>
                                </div>
                            </td>
                            <td class="actions">
                                <select class="status-select" onchange="updateBookingStatus(<?php echo $booking['id']; ?>, this.value)">
                                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>En attente</option>
                                    <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmé</option>
                                    <option value="completed" <?php echo $booking['status'] === 'completed' ? 'selected' : ''; ?>>Terminé</option>
                                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Annulé</option>
                                </select>
                                <a href="#" onclick="deleteBooking(<?php echo $booking['id']; ?>)" class="btn-delete" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <ul>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="<?php echo $page == $i ? 'active' : ''; ?>">
                        <a href="index.php?action=admin&page=bookings&p=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Styles spécifiques pour la gestion des réservations */
.filter-status {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-select {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: white;
    min-width: 140px;
}

.notes-cell {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.notes-cell:hover {
    white-space: normal;
    overflow: visible;
    position: relative;
    z-index: 1;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 0.5rem;
    border-radius: 4px;
}

/* Styles pour les statuts */
.booking-status {
    padding: 0.3rem;
    border-radius: 4px;
    width: 120px;
    font-size: 0.9rem;
}

.booking-status[data-status="pending"] {
    border: 1px solid #856404;
    background: #fff3cd;
    color: #856404;
}

.booking-status[data-status="confirmed"] {
    border: 1px solid #155724;
    background: #d4edda;
    color: #155724;
}

.booking-status[data-status="completed"] {
    border: 1px solid #004085;
    background: #cce5ff;
    color: #004085;
}

.booking-status[data-status="cancelled"] {
    border: 1px solid #721c24;
    background: #f8d7da;
    color: #721c24;
}

.btn-delete {
    background: #dc3545;
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    margin-left: 0.5rem;
}

.btn-delete:hover {
    background: #c82333;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtre par statut
    document.getElementById('status-filter').addEventListener('change', function() {
        const status = this.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Mise à jour du statut
    document.querySelectorAll('.booking-status').forEach(select => {
        select.addEventListener('change', function() {
            const bookingId = this.dataset.bookingId;
            const newStatus = this.value;
            
            fetch('index.php?action=admin&operation=updateBookingStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `booking_id=${bookingId}&status=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closest('tr').dataset.status = newStatus;
                    alert('Statut mis à jour avec succès !');
                } else {
                    alert('Échec de la mise à jour du statut.');
                    // Rétablir l'ancienne valeur
                    this.value = this.dataset.originalStatus;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la mise à jour du statut.');
                this.value = this.dataset.originalStatus;
            });
        });

        // Sauvegarder le statut original
        select.dataset.originalStatus = select.value;
    });

    // Suppression des réservations
    document.querySelectorAll('.delete-booking').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ? Cette action est irréversible.')) {
                const bookingId = this.dataset.bookingId;
                
                fetch('index.php?action=admin&operation=deleteBooking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `booking_id=${bookingId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('tr').remove();
                        alert('Réservation supprimée avec succès !');
                    } else {
                        alert('Échec de la suppression de la réservation.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la suppression de la réservation.');
                });
            }
        });
    });
});

function updateBookingStatus(bookingId, newStatus) {
    fetch('index.php?action=admin&operation=updateBookingStatus', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `booking_id=${bookingId}&status=${newStatus}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mise à jour réussie
            const row = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
            if (row) {
                row.querySelector('.status-cell').textContent = getStatusLabel(newStatus);
            }
        } else {
            alert('Échec de la mise à jour du statut.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors de la mise à jour du statut.');
    });
}

function deleteBooking(bookingId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ? Cette action est irréversible.')) {
        fetch('index.php?action=admin&operation=deleteBooking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'booking_id=' + bookingId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Trouver et supprimer la ligne du tableau
                const row = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
                if (row) {
                    row.remove();
                }
                alert('Réservation supprimée avec succès !');
            } else {
                alert('Échec de la suppression de la réservation.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue lors de la suppression de la réservation.');
        });
    }
}

function getStatusLabel(status) {
    const labels = {
        'pending': 'En attente',
        'confirmed': 'Confirmé',
        'completed': 'Terminé',
        'cancelled': 'Annulé'
    };
    return labels[status] || status;
}
</script>

<?php include('./views/layout/footer.php'); ?> 