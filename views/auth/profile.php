<!-- views/auth/profile.php -->
<?php include('./views/layout/header.php'); ?>

<div class="container">
    <div class="profile-box">
        <h1 class="profile-title">Mon Profil</h1>
        
        <!-- Messages d'alerte -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['password_updated']) && $_GET['password_updated'] == 1): ?>
            <div class="alert alert-success">
                Votre mot de passe a été mis à jour avec succès !
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="alert alert-error">
                Une erreur est survenue lors de la mise à jour du profil.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 2): ?>
            <div class="alert alert-error">
                Une erreur est survenue lors de la mise à jour du mot de passe.
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['password_errors']) && !empty($_SESSION['password_errors'])): ?>
            <div class="alert alert-error">
                <?php foreach($_SESSION['password_errors'] as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
                <?php unset($_SESSION['password_errors']); ?>
            </div>
        <?php endif; ?>

        <!-- Onglets de navigation -->
        <div class="profile-tabs">
            <button class="tab-button active" onclick="openTab(event, 'info-tab')">
                <i class="fas fa-user"></i> Informations personnelles
            </button>
            <button class="tab-button" onclick="openTab(event, 'password-tab')">
                <i class="fas fa-key"></i> Changer mot de passe
            </button>
            <button class="tab-button" onclick="window.location.href='index.php?action=my_bookings'">
                <i class="fas fa-calendar"></i> Mes réservations
            </button>
        </div>

        <!-- Tab content -->
        <div id="info-tab" class="tab-content" style="display: block;">
            <form action="index.php?action=profile_update" method="POST" class="profile-form">
                <div class="form-card">
                    <div class="form-header">
                        <i class="fas fa-user-circle profile-icon"></i>
                        <h2>Informations personnelles</h2>
                        <p>Modifiez vos informations de contact</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstname">Prénom</label>
                            <input type="text" id="firstname" name="firstname" 
                                value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="lastname">Nom</label>
                            <input type="text" id="lastname" name="lastname" 
                                value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="phone" name="phone" 
                                value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        Mettre à jour le profil
                    </button>
                </div>
            </form>
        </div>

        <div id="password-tab" class="tab-content">
            <form action="index.php?action=password_update" method="POST" class="profile-form">
                <div class="form-card">
                    <div class="form-header">
                        <i class="fas fa-shield-alt profile-icon"></i>
                        <h2>Changer le mot de passe</h2>
                        <p>Pour votre sécurité, choisissez un mot de passe fort</p>
                    </div>
                
                    <div class="form-group">
                        <label for="current_password">Mot de passe actuel</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="new_password">Nouveau mot de passe</label>
                            <div class="input-with-icon">
                                <i class="fas fa-key"></i>
                                <input type="password" id="new_password" name="new_password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirmer le mot de passe</label>
                            <div class="input-with-icon">
                                <i class="fas fa-check-circle"></i>
                                <input type="password" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                    </div>

                    <div class="password-requirements">
                        <p><i class="fas fa-info-circle"></i> Le mot de passe doit contenir au moins 8 caractères</p>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-key"></i>
                        Changer le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.profile-box {
    background: white;
    border-radius: 15px;
    padding: 0;
    margin: 2rem auto;
    max-width: 900px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.profile-title {
    color: white;
    text-align: center;
    margin: 0;
    padding: 1.5rem;
    background: var(--gradient-primary);
    position: relative;
}

.profile-tabs {
    display: flex;
    background: #f5f5f5;
    border-bottom: 1px solid #eee;
    overflow-x: auto;
}

.tab-button {
    background-color: transparent;
    border: none;
    padding: 1rem 2rem;
    cursor: pointer;
    font-weight: 500;
    color: var(--dark-color);
    font-size: 1rem;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.tab-button i {
    margin-right: 0.5rem;
}

.tab-button.active {
    color: var(--primary-color);
    border-bottom: 3px solid var(--primary-color);
}

.tab-button:hover {
    background-color: #eee;
}

.tab-content {
    display: none;
    padding: 2rem;
}

.form-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.profile-icon {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.form-header h2 {
    color: var(--primary-color);
    margin: 0;
    margin-bottom: 0.5rem;
}

.form-header p {
    color: #666;
    margin: 0;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.input-with-icon {
    position: relative;
}

.input-with-icon input,
.input-with-icon textarea {
    padding-left: 2.5rem;
    width: 100%;
}

.input-with-icon i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}

.form-group input,
.form-group textarea {
    padding: 0.8rem;
    border: 2px solid #eee;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255,107,107,0.25);
    outline: none;
}

.btn-primary {
    background: var(--gradient-primary);
    border: none;
    color: white;
    padding: 1rem 2rem;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    font-size: 1rem;
    display: block;
    width: 100%;
    margin-top: 1rem;
    transition: all 0.3s ease;
}

.btn-primary i {
    margin-right: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 14px rgba(255,107,107,0.25);
}

.password-requirements {
    background-color: #f9f9f9;
    padding: 1rem;
    border-radius: 10px;
    margin-top: 1rem;
}

.password-requirements p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.alert {
    padding: 1rem;
    border-radius: 10px;
    margin: 1rem 2rem;
    position: relative;
}

.alert-success {
    background-color: #dcfce7;
    color: #166534;
    border-left: 4px solid #16a34a;
}

.alert-error {
    background-color: #fee2e2;
    color: #b91c1c;
    border-left: 4px solid #dc2626;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
}
</style>

<script>
function openTab(evt, tabName) {
    // Déclaration des variables
    var i, tabcontent, tabbuttons;

    // Masquer tous les contenus d'onglets
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Supprimer la classe "active" de tous les boutons d'onglets
    tabbuttons = document.getElementsByClassName("tab-button");
    for (i = 0; i < tabbuttons.length; i++) {
        tabbuttons[i].className = tabbuttons[i].className.replace(" active", "");
    }

    // Afficher l'onglet actuel et ajouter la classe "active" au bouton correspondant
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Par défaut, ouvrir l'onglet "info-tab"
document.getElementById("info-tab").style.display = "block";
</script>

<?php include('./views/layout/footer.php'); ?>