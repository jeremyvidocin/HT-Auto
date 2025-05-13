<?php
/*
* Ce fichier contient les styles standardisés pour les alertes à travers le site
* Inclure ce fichier dans le header.php pour l'avoir disponible sur toutes les pages
*/
?>
<style>
/* Styles pour les alertes et notifications */
.alert {
    position: relative;
    padding: 1rem 1rem 1rem 3rem;
    margin-bottom: 1rem;
    border-radius: 10px;
    border-left: 4px solid transparent;
}

.alert i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
}

.alert-success {
    background-color: #dcfce7;
    color: #166534;
    border-left-color: #16a34a;
}

.alert-success i {
    color: #16a34a;
}

.alert-error {
    background-color: #fee2e2;
    color: #b91c1c;
    border-left-color: #dc2626;
}

.alert-error i {
    color: #dc2626;
}

.alert-warning {
    background-color: #fef3c7;
    color: #92400e;
    border-left-color: #f59e0b;
}

.alert-warning i {
    color: #f59e0b;
}

.alert-info {
    background-color: #dbeafe;
    color: #1e40af;
    border-left-color: #3b82f6;
}

.alert-info i {
    color: #3b82f6;
}

/* Animation pour les alertes */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert {
    animation: fadeIn 0.3s ease forwards;
}
</style>