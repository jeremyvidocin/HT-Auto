<?php
// views/auth/login.php
include('./views/layout/header.php'); ?>

<div class="container">
    <div class="auth-box">
        <h1 class="auth-title">Connexion</h1>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php 
                echo htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=login" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-primary">Se connecter</button>
        </form>

        <p class="auth-links">
            Pas encore de compte ? 
            <a href="index.php?action=register">Créer un compte</a>
        </p>
    </div>
</div>

<style>
    .auth-box {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        max-width: 500px;
        margin: 2rem auto;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .auth-title {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        color: var(--primary-color);
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea {
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        padding: 1rem;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #34495e;
    }

    .auth-links {
        text-align: center;
        margin-top: 1.5rem;
        color: #666;
    }

    .auth-links a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .auth-links a:hover {
        text-decoration: underline;
    }

    .alert {
        padding: 1rem;
        border-radius: 5px;
        margin-bottom: 1.5rem;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #16a34a;
    }
</style>