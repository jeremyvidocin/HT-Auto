<?php include('./views/layout/header.php'); ?>

<div class="contact-hero">
    <div class="hero-content">
        <h1>Contactez-nous</h1>
        <p>Notre équipe est à votre disposition pour répondre à toutes vos questions</p>
    </div>
</div>

<div class="container contact-section">
    <div class="contact-grid">
        <!-- Formulaire de contact -->
        <div class="contact-form-container">
            <div class="form-card">
                <h2>Envoyez-nous un message</h2>
                <form action="https://getform.io/f/bollnnma" method="POST" class="contact-form">
                    <input type="hidden" name="_redirect" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/index.php?action=contact&success=1'; ?>">
                    <input type="hidden" name="_email.to" value="jeremyvidocin@gmail.com">
                    
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <select id="subject" name="subject" required class="form-input">
                            <option value="">Choisissez un sujet</option>
                            <option value="info">Demande d'information</option>
                            <option value="rdv">Prise de rendez-vous</option>
                            <option value="essai">Demande d'essai</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required class="form-input" rows="5"></textarea>
                    </div>

                    <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.
                    </div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn-submit">Envoyer le message</button>
                </form>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="contact-info-container">
            <div class="info-card">
                <h2>Nos Coordonnées</h2>
                
                <div class="info-block">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Adresse</h3>
                        <p><?php echo $dealership['address']; ?></p>
                    </div>
                </div>

                <div class="info-block">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h3>Téléphone</h3>
                        <p><?php echo $dealership['phone']; ?></p>
                    </div>
                </div>

                <div class="info-block">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>Email</h3>
                        <p><?php echo $dealership['email']; ?></p>
                    </div>
                </div>

                <div class="hours-block">
                    <h3><i class="fas fa-clock"></i> Horaires d'ouverture</h3>
                    <?php foreach($dealership['hours'] as $day => $hours): ?>
                        <div class="hour-line">
                            <span class="day"><?php echo $day; ?></span>
                            <span class="hours"><?php echo $hours; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Carte -->
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937595!2d2.292292615674431!3d48.85837007928746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sTour%20Eiffel!5e0!3m2!1sfr!2sfr!4v1631234567890!5m2!1sfr!2sfr" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-hero {
    background: var(--gradient-primary);
    padding: 6rem 2rem;
    text-align: center;
    color: white;
    clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    margin-bottom: 2rem;
}

.contact-section {
    padding: 2rem 0;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.form-card, .info-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: var(--shadow-primary);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-input {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid #eee;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-input:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(255,107,107,0.2);
}

.btn-submit {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    cursor: pointer;
    width: 100%;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-secondary);
}

.info-block {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-block i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.hours-block {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #eee;
}

.hour-line {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
}

.map-container {
    margin-top: 2rem;
    border-radius: 10px;
    overflow: hidden;
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
</style>

<?php include('./views/layout/footer.php'); ?>