<?php include('./views/layout/header.php'); ?>
<link rel="stylesheet" href="views/admin/admin.css">

<div class="admin-container">
    <div class="admin-sidebar">
        <h3>Administration</h3>
        <nav>
            <a href="index.php?action=admin">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
            <a href="index.php?action=admin&page=users" class="active">
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
        <div class="admin-header">
            <h1>Gestion des utilisateurs</h1>
            <button class="btn-primary" onclick="location.href='index.php?action=admin&page=users&op=add'">
                <i class="fas fa-plus"></i> Ajouter un utilisateur
            </button>
        </div>

        <div class="admin-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Rôle</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td>
                                <select class="role-select" 
                                        data-user-id="<?php echo $user['id']; ?>"
                                        <?php echo ($user['id'] == $_SESSION['user_id']) ? 'disabled' : ''; ?>>
                                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <button class="btn-delete delete-user" 
                                        data-user-id="<?php echo $user['id']; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
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
                        <a href="index.php?action=admin&page=users&p=<?php echo $i; ?>">
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

<!-- JavaScript for user management -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle role changes
    document.querySelectorAll('.role-select').forEach(select => {
        select.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const newRole = this.value;
            
            fetch('index.php?action=admin&operation=updateUserRole', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `user_id=${userId}&role=${newRole}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Rôle de l\'utilisateur mis à jour avec succès !');
                } else {
                    alert('Échec de la mise à jour du rôle.');
                    this.value = this.value === 'admin' ? 'user' : 'admin';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la mise à jour du rôle.');
                this.value = this.value === 'admin' ? 'user' : 'admin';
            });
        });
    });

    // Handle user deletion
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
                const userId = this.dataset.userId;
                
                fetch('index.php?action=admin&operation=deleteUser', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('tr').remove();
                        alert('Utilisateur supprimé avec succès !');
                    } else {
                        alert('Échec de la suppression de l\'utilisateur.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la suppression de l\'utilisateur.');
                });
            }
        });
    });
});
</script>

<?php include('./views/layout/footer.php'); ?> 