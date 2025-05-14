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
            <h1>Gestion des véhicules</h1>
            <button class="btn-primary" onclick="location.href='index.php?action=admin&page=cars&op=add'">
                <i class="fas fa-plus"></i> Ajouter un véhicule
            </button>
        </div>

        <div class="admin-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Année</th>
                            <th>Prix</th>
                            <th>Kilométrage</th>
                            <th>Carburant</th>
                            <th>Transmission</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cars as $car): ?>
                        <tr data-car-id="<?php echo $car['id']; ?>">
                            <td>
                                <img src="<?php echo htmlspecialchars($car['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>"
                                     class="car-thumbnail">
                            </td>
                            <td><?php echo htmlspecialchars($car['brand']); ?></td>
                            <td><?php echo htmlspecialchars($car['model']); ?></td>
                            <td><?php echo htmlspecialchars($car['year']); ?></td>
                            <td><?php echo number_format($car['price'], 2, ',', ' '); ?> €</td>
                            <td><?php echo number_format($car['mileage'], 0, ',', ' '); ?> km</td>
                            <td><?php echo htmlspecialchars($car['fuel_type']); ?></td>
                            <td><?php echo htmlspecialchars($car['transmission']); ?></td>
                            <td class="actions">
                                <a href="index.php?action=admin&page=cars&op=edit&id=<?php echo $car['id']; ?>" 
                                   class="btn-edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" onclick="deleteCar(<?php echo $car['id']; ?>)" 
                                   class="btn-delete" title="Supprimer">
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
                        <a href="index.php?action=admin&page=cars&p=<?php echo $i; ?>">
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
/* Styles spécifiques pour la gestion des voitures */
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.btn-primary:hover {
    background: var(--primary-color-dark);
}

.car-thumbnail {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-edit {
    background: #ffc107;
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    cursor: pointer;
}

.btn-edit:hover {
    background: #e0a800;
}
</style>

<script>
function deleteCar(carId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ? Cette action est irréversible.')) {
        fetch('index.php?action=admin&operation=deleteCar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'car_id=' + carId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Trouver et supprimer la ligne du tableau
                const row = document.querySelector(`tr[data-car-id="${carId}"]`);
                if (row) {
                    row.remove();
                }
                alert('Véhicule supprimé avec succès !');
            } else {
                alert('Échec de la suppression du véhicule.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue lors de la suppression du véhicule.');
        });
    }
}
</script>

<?php include('./views/layout/footer.php'); ?> 