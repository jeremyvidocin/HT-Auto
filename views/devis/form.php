<?php require_once './views/layout/header.php'; ?>

<style>
.devis-container {
    max-width: 1000px;
    margin: 8rem auto 3rem;
    padding: 0 20px;
}

.devis-title {
    text-align: center;
    margin-bottom: 3rem;
    color: var(--primary-color);
    position: relative;
    padding-bottom: 1rem;
}

.devis-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: var(--gradient-primary);
    border-radius: 3px;
}

.devis-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.devis-header {
    background: var(--gradient-primary);
    padding: 2rem;
    color: white;
    text-align: center;
}

.devis-header h2 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 600;
}

.devis-header p {
    margin-top: 0.5rem;
    opacity: 0.9;
}

.devis-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid #e1e1e1;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255,107,107,0.1);
}

.form-select {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid #e1e1e1;
    border-radius: 8px;
    transition: all 0.3s ease;
    background-color: white;
}

.form-text {
    margin-top: 0.5rem;
    color: #666;
    font-size: 0.9rem;
}

.btn-group {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 0.8rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--gradient-primary);
    border: none;
    color: white;
    box-shadow: var(--shadow-primary);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-secondary);
}

.btn-secondary {
    background: white;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-secondary:hover {
    background: rgba(255,107,107,0.1);
}

.section-title {
    color: var(--primary-color);
    margin: 2rem 0 1rem;
    font-size: 1.2rem;
    font-weight: 600;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--light-gray);
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-danger {
    background-color: rgba(255, 107, 107, 0.1);
    border: 1px solid #ff6b6b;
    color: #ff6b6b;
}

.alert ul {
    margin: 0;
    padding-left: 1.5rem;
}

.form-control[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.info-badge {
    display: inline-block;
    padding: 0.2rem 0.5rem;
    background: rgba(255, 107, 107, 0.1);
    color: var(--primary-color);
    border-radius: 4px;
    font-size: 0.8rem;
    margin-left: 0.5rem;
}
</style>

<div class="devis-container">
    <h1 class="devis-title">Simulateur de Financement</h1>
    
    <div class="devis-card">
        <div class="devis-header">
            <h2>Calculateur de Financement Automobile</h2>
            <p>Obtenez une simulation personnalisée en quelques clics</p>
        </div>
        
        <div class="devis-body">
            <div id="error-container" class="alert alert-danger" style="display: none;">
                <strong>Des erreurs sont survenues :</strong>
                <ul id="error-list"></ul>
            </div>

            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-danger">
                    <strong>Des erreurs sont survenues :</strong>
                    <ul>
                        <?php 
                        foreach ($_SESSION['errors'] as $error) {
                            echo "<li>" . htmlspecialchars($error) . "</li>";
                        }
                        unset($_SESSION['errors']);
                        ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="devisForm" method="POST" action="index.php?action=generate_devis" onsubmit="return validateForm(event)">
                <h3 class="section-title">Informations personnelles</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="nom" name="nom" 
                                value="<?php echo isset($_SESSION['form_data']['nom']) ? htmlspecialchars($_SESSION['form_data']['nom']) : (isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''); ?>" 
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : (isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''); ?>"
                                required>
                        </div>
                    </div>
                </div>

                <h3 class="section-title">Détails du véhicule</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vehicule" class="form-label">
                                Modèle du véhicule
                                <span class="info-badge">Non modifiable</span>
                            </label>
                            <input type="text" class="form-control" id="vehicule" name="vehicule" 
                                value="<?php echo $car ? htmlspecialchars($car['brand'] . ' ' . $car['model']) : ''; ?>"
                                readonly required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prix" class="form-label">
                                Prix du véhicule (€)
                                <span class="info-badge">Non modifiable</span>
                            </label>
                            <input type="number" class="form-control" id="prix" name="prix" 
                                value="<?php echo $car ? htmlspecialchars($car['price']) : ''; ?>"
                                readonly required>
                        </div>
                    </div>
                </div>

                <h3 class="section-title">Conditions de financement</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="apport" class="form-label">Apport initial (€)</label>
                            <input type="number" class="form-control" id="apport" name="apport" 
                                min="<?php echo $car ? $car['price'] * 0.1 : 0; ?>"
                                max="<?php echo $car ? $car['price'] - 1 : 0; ?>"
                                value="<?php echo isset($_SESSION['form_data']['apport']) ? htmlspecialchars($_SESSION['form_data']['apport']) : ''; ?>"
                                required>
                            <div class="form-text">Minimum requis : <?php echo $car ? number_format($car['price'] * 0.1, 2, ',', ' ') : 0; ?> € (10% du prix)</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="duree" class="form-label">Durée du prêt</label>
                            <select class="form-select" id="duree" name="duree" required>
                                <?php
                                $durees = [12 => '12 mois', 24 => '24 mois', 36 => '36 mois', 48 => '48 mois', 60 => '60 mois'];
                                $selected_duree = isset($_SESSION['form_data']['duree']) ? intval($_SESSION['form_data']['duree']) : 36;
                                foreach ($durees as $value => $label) {
                                    echo '<option value="' . $value . '"' . ($selected_duree === $value ? ' selected' : '') . '>' . $label . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="taux" class="form-label">Taux d'intérêt annuel (%)</label>
                            <input type="number" class="form-control" id="taux" name="taux" 
                                step="0.01" min="0.01" max="20" 
                                value="<?php echo isset($_SESSION['form_data']['taux']) ? htmlspecialchars($_SESSION['form_data']['taux']) : '4.99'; ?>"
                                required>
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Générer le devis PDF
                    </button>
                    <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'index.php'; ?>" 
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm(event) {
    event.preventDefault();
    const errors = [];
    const form = document.getElementById('devisForm');
    const errorContainer = document.getElementById('error-container');
    const errorList = document.getElementById('error-list');
    
    // Réinitialiser les erreurs
    errorList.innerHTML = '';
    errorContainer.style.display = 'none';
    
    // Validation du nom
    const nom = form.querySelector('[name="nom"]').value.trim();
    if (!nom) {
        errors.push("Le nom est obligatoire");
    }
    
    // Validation de l'email
    const email = form.querySelector('[name="email"]').value.trim();
    if (!email) {
        errors.push("L'email est obligatoire");
    } else if (!isValidEmail(email)) {
        errors.push("L'adresse email n'est pas valide");
    }
    
    // Validation du véhicule
    const vehicule = form.querySelector('[name="vehicule"]').value.trim();
    if (!vehicule) {
        errors.push("Le véhicule est obligatoire");
    }
    
    // Validation du prix
    const prix = parseFloat(form.querySelector('[name="prix"]').value.trim());
    if (isNaN(prix) || prix <= 0) {
        errors.push("Le prix est obligatoire et doit être supérieur à 0");
    }
    
    // Validation de l'apport
    const apport = parseFloat(form.querySelector('[name="apport"]').value.trim());
    if (isNaN(apport)) {
        errors.push("L'apport est obligatoire");
    } else {
        const apportMinimum = prix * 0.1;
        if (apport < apportMinimum) {
            errors.push(`L'apport minimum doit être de ${formatMontant(apportMinimum)} € (10% du prix du véhicule)`);
        } else if (apport >= prix) {
            errors.push("L'apport ne peut pas être supérieur ou égal au prix du véhicule");
        }
    }
    
    // Validation de la durée
    const duree = parseInt(form.querySelector('[name="duree"]').value.trim());
    if (isNaN(duree) || ![12, 24, 36, 48, 60].includes(duree)) {
        errors.push("La durée est obligatoire et doit être une valeur valide");
    }
    
    // Validation du taux
    const taux = parseFloat(form.querySelector('[name="taux"]').value.trim());
    if (isNaN(taux) || taux <= 0 || taux > 20) {
        errors.push("Le taux est obligatoire et doit être compris entre 0 et 20%");
    }
    
    // Afficher les erreurs s'il y en a
    if (errors.length > 0) {
        errorContainer.style.display = 'block';
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        // Scroll vers les erreurs
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        return false;
    }
    
    // Si tout est valide, soumettre le formulaire
    form.submit();
    return true;
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function formatMontant(montant) {
    return new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(montant);
}

// Ajouter des écouteurs d'événements pour la validation en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('#devisForm input, #devisForm select');
    inputs.forEach(input => {
        input.addEventListener('change', () => validateForm(new Event('change')));
    });
});
</script>

<?php 
// Nettoyage des données du formulaire en session après affichage
unset($_SESSION['form_data']); 
require_once './views/layout/footer.php'; 
?> 