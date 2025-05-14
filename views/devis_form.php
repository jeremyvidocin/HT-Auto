<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis Financement Auto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Calculateur de Financement Automobile</h2>
        <form action="controllers/generate_devis.php" method="post" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom complet</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="vehicule" class="form-label">Modèle du véhicule</label>
                    <input type="text" class="form-control" id="vehicule" name="vehicule" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="prix" class="form-label">Prix du véhicule (€)</label>
                    <input type="number" class="form-control" id="prix" name="prix" min="0" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="apport" class="form-label">Apport initial (€)</label>
                    <input type="number" class="form-control" id="apport" name="apport" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="duree" class="form-label">Durée du prêt (mois)</label>
                    <select class="form-select" id="duree" name="duree" required>
                        <option value="12">12 mois</option>
                        <option value="24">24 mois</option>
                        <option value="36">36 mois</option>
                        <option value="48">48 mois</option>
                        <option value="60">60 mois</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="taux" class="form-label">Taux d'intérêt annuel (%)</label>
                    <input type="number" class="form-control" id="taux" name="taux" step="0.01" min="0" max="20" value="4.99" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Générer le devis PDF</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validation des formulaires Bootstrap
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html> 