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
            <h1>Ajouter un utilisateur</h1>
            <button class="btn-secondary" onclick="location.href='index.php?action=admin&page=users'">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </button>
        </div>

        <div class="admin-card">
            <form action="index.php?action=admin&operation=addUser" method="POST" class="form-grid">
                <div class="form-group">
                    <label for="firstname">Prénom*</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Nom*</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}">
                    <small>Format: 0612345678</small>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe*</label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <small>Minimum 8 caractères</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe*</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                </div>

                <div class="form-group">
                    <label for="role">Rôle*</label>
                    <select id="role" name="role" required>
                        <option value="">Sélectionnez...</option>
                        <option value="user">Utilisateur</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Statut*</label>
                    <select id="status" name="status" required>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="address">Adresse</label>
                    <textarea id="address" name="address" rows="3"></textarea>
                </div>

                <div class="form-actions full-width">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Enregistrer l'utilisateur
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
.form-group input[type="email"],
.form-group input[type="tel"],
.form-group input[type="password"],
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

small {
    color: #666;
    font-size: 0.85rem;
}

/* Validation styles */
input:invalid {
    border-color: #dc3545;
}

input:valid {
    border-color: #28a745;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    // Validation du formulaire
    form.addEventListener('submit', function(event) {
        if (password.value !== confirmPassword.value) {
            event.preventDefault();
            alert('Les mots de passe ne correspondent pas !');
        }
    });

    // Validation en temps réel des mots de passe
    confirmPassword.addEventListener('input', function() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });
});
</script>

<?php include('./views/layout/footer.php'); ?> 